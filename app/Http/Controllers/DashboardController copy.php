<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Land;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Quotation;
use App\Models\QuotationZoneManage;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteItemValue;
use App\Models\Template;
use App\Models\TemplateItem;
use App\Models\TemplateItemValue;
use App\Models\Term;
use App\Models\TermInfo;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // public function databaseBackup()
    // {
    //     try {
    //         // Define the backup directory
    //         $backupDir = storage_path('app/backups/');
    
    //         // Create the backup directory if it doesn't exist
    //         if (!file_exists($backupDir) && !mkdir($backupDir, 0755, true) && !is_dir($backupDir)) {
    //             Log::error('Failed to create backup directory', ['directory' => $backupDir]);
    //             return redirect()->back()->withErrors('Failed to create backup directory.');
    //         }
    
    //         // Define the backup file path with a timestamp
    //         $backupPath = $backupDir . 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
    
    //         // Create a temporary file for MySQL credentials
    //         $optionsFile = tempnam(sys_get_temp_dir(), 'mysql_backup');
    //         if ($optionsFile === false) {
    //             Log::error('Failed to create temporary options file.');
    //             return redirect()->back()->withErrors('Failed to create temporary options file.');
    //         }
    
    //         // Write MySQL credentials to the temporary file
    //         file_put_contents($optionsFile, sprintf(
    //             "[client]\nhost=%s\nuser=%s\npassword=%s",
    //             env('DB_HOST'),
    //             env('DB_USERNAME'),
    //             env('DB_PASSWORD')
    //         ));
    
    //         // Build the mysqldump command
    //         $command = sprintf(
    //             'mysqldump --defaults-extra-file=%s %s > %s 2>&1',
    //             escapeshellarg($optionsFile),
    //             escapeshellarg(env('DB_DATABASE')),
    //             escapeshellarg($backupPath)
    //         );
    
    //         // Execute the command
    //         exec($command, $output, $returnCode);
    
    //         // Remove the temporary file
    //         unlink($optionsFile);
    
    //         // Check if the command was successful
    //         if ($returnCode !== 0) {
    //             Log::error('Database backup command failed', ['command' => $command, 'output' => $output, 'returnCode' => $returnCode]);
    //             return redirect()->back()->withErrors('Database backup failed: ' . implode("\n", $output));
    //         }
    
    //         // Verify if the backup file was created
    //         if (!file_exists($backupPath)) {
    //             Log::error('Database backup file was not created', ['backupPath' => $backupPath]);
    //             return redirect()->back()->withErrors('Database backup file was not created.');
    //         }
    
    //         // Stream the backup file to the browser
    //         return response()->download($backupPath)->deleteFileAfterSend(true);
    
    //     } catch (\Exception $e) {
    //         // Handle unexpected errors
    //         Log::error('An unexpected error occurred during the database backup', ['exception' => $e]);
    //         return redirect()->back()->withErrors('An unexpected error occurred: ' . $e->getMessage());
    //     }
    // }

    public function databaseBackup()
    {
        try {
            // Define the backup directory and file path
            $backupDir = storage_path('app/backups/');
            if (!file_exists($backupDir) && !mkdir($backupDir, 0755, true) && !is_dir($backupDir)) {
                Log::error('Failed to create backup directory', ['directory' => $backupDir]);
                return;
            }
            $backupPath = $backupDir . 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
    
            // Create a temporary file for MySQL credentials
            $optionsFile = tempnam(sys_get_temp_dir(), 'mysql_backup');
            if ($optionsFile === false) {
                Log::error('Failed to create temporary options file.');
                return;
            }
            file_put_contents($optionsFile, sprintf(
                "[client]\nhost=%s\nuser=%s\npassword=%s",
                env('DB_HOST'),
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            ));
    
            // Run the mysqldump command
            $command = sprintf(
                'mysqldump --defaults-extra-file=%s %s > %s 2>&1',
                escapeshellarg($optionsFile),
                escapeshellarg(env('DB_DATABASE')),
                escapeshellarg($backupPath)
            );
            exec($command, $output, $returnCode);
            unlink($optionsFile);
    
            if ($returnCode !== 0) {
                Log::error('Database backup command failed', ['command' => $command, 'output' => $output, 'returnCode' => $returnCode]);
                return;
            }
    
            // Upload to Google Drive
            $this->uploadToGoogleDrive($backupPath);
    
            // Clean up local file
            unlink($backupPath);
    
            dd('done');
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred during the database backup', ['exception' => $e]);
        }
    }
    
    private function uploadToGoogleDrive($filePath)
    {
        try {
            // Initialize Google Client
            $client = new \Google\Client();
            $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
            $client->setAccessType('offline'); // Ensure offline access for refresh token
            $client->setScopes([\Google\Service\Drive::DRIVE_FILE, \Google\Service\Drive::DRIVE]);
            $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
    
            // Initialize Google Drive service
            $service = new \Google\Service\Drive($client);
            $file = new \Google\Service\Drive\DriveFile();
            $file->setName(basename($filePath));
            $file->setParents([env('GOOGLE_DRIVE_FOLDER_ID')]);
    
            // Upload the file
            $service->files->create($file, [
                'data' => file_get_contents($filePath),
                'mimeType' => 'application/sql',
                'uploadType' => 'multipart',
            ]);
    
            // Delete old backups
            $this->deleteOldBackups($service);
        } catch (\Google\Service\Exception $e) {
            Log::error('Google Service Exception: ' . $e->getMessage(), ['code' => $e->getCode(), 'errors' => $e->getErrors()]);
        } catch (\Exception $e) {
            Log::error('General Exception: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
    
    
    private function deleteOldBackups($service)
    {
        try {
            $folderId = env('GOOGLE_DRIVE_FOLDER_ID');
            $files = $service->files->listFiles([
                'q' => "'$folderId' in parents",
                'fields' => 'files(id, name, createdTime)',
                'orderBy' => 'createdTime desc',
            ]);
    
            $filesToDelete = array_slice($files->files, 2); // Keep only the latest 2 backups
            foreach ($filesToDelete as $file) {
                $service->files->delete($file->getId());
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete old backups from Google Drive', ['exception' => $e]);
        }
    }

    public function index()
    {
        $user = User::where('id', Auth()->user()->id)->first();

        if($user->role_id == 1 || $user->role_id == 2){
            return view('backend.dashboard');
        }
        else{
            return view('welcome');
        }
    }

    public function goToSheet()
    {
        $quotes = Quote::latest()->limit(6)->get();
        return view('backend.quotes.dashboard', compact('quotes'));
    }

    public function template()
    {
        $templates = Template::latest()->limit(6)->get();
        return view('backend.quotes.dashboard', compact('templates'));
    }

    public function editableTable($id = null)
    {
        $organization = Organization::latest()->first();
        $quotation = Quotation::find($id);
        $quotations = Quotation::latest()->get();
        $payments = Payment::orderBy('sequence', 'asc')->get();
        $terms = Term::get();
        $bank = Bank::latest()->first();
        $termInfo = TermInfo::latest()->first();
        return view('backend.quotes.editable', compact('quotation','quotations','organization','payments','terms','bank','termInfo'));
    }

    public function pdf($id)
    {
        $quote = Quote::find($id);

        if ($quote) {
            $quoteZoneItems = QuoteItem::with('quoteItemValues')
                ->where('quote_id', $id)
                ->whereNotNull('sub_category_id')
                ->get()
                ->groupBy(['category_id', 'sub_category_id']);

            // Retrieve QuoteItems with null sub_category_id
            $quoteWorkItems = QuoteItem::with('quoteItemValues')
                ->where('quote_id', $id)
                ->whereNull('sub_category_id')
                ->get()
                ->groupBy(['category_id', 'sub_category_id']);

            if(!$quoteZoneItems->isEmpty()) {
                // Merge the two collections, ignoring keys from $quoteWorkItems if they exist in $quoteZoneItems
                $quoteItems = $quoteZoneItems->merge($quoteWorkItems->except($quoteZoneItems->keys()->all()));
            } else {
                $quoteItems = $quoteWorkItems;
            }


            $externalMenus = QuoteItemValue::where('quote_id', $quote->id)->distinct()->pluck('header');
            $organization = Organization::latest()->first();

            $view = view('backend.quotes.pdf', compact('quote','organization','externalMenus','quoteItems'))->render();

            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'format' => 'A4-L',
                'margin_left' => 4,
                'margin_right' => 0,
                'margin_top' => 4,
                'margin_bottom' => 0,
            ]);
            $mpdf->SetTitle('Quotation');
            $mpdf->WriteHTML($view);
            $mpdf->Output(time() . '-Sheet' . ".pdf", "I");
        } else {
            return redirect()->back();
        }

    }
    
    public function destroy($id)
    {
        try{
            $quote = Quote::find($id);
            $quote->update(['deleted_by' => auth()->user()->id]);
            $quote->delete();

            foreach ($quote->quoteItems as $key => $quoteItem) {
                $quoteItem->update(['deleted_by' => auth()->user()->id]);
                $quoteItem->delete();

                foreach ($quoteItem->quoteItemValues as $key => $quoteItemValue) {
                    $quoteItemValue->update(['deleted_by' => auth()->user()->id]);
                    $quoteItemValue->delete();
                }
            }

            return redirect()->route('quotations.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        $quote = Quote::find($id);
        $organization = Organization::latest()->first();
        $quotations = Quotation::latest()->get();
        $externalMenus = QuoteItemValue::where('quote_id', $quote->id)->distinct()->pluck('header');
        $quoteItems = QuoteItem::with('quoteItemValues')->where('quote_id',$id)->get()->groupBy('category_id');
        $payments = Payment::orderBy('sequence', 'asc')->get();
        $quotation = Quotation::find($quote->quotation_id);
        $terms = Term::get();
        $bank = Bank::latest()->first();
        $categories = Category::orderBY('title','asc')
                            ->pluck('title','id')
                            ->toArray();
        $termInfo = TermInfo::latest()->first();
        $quoteItems = QuoteItem::with('quoteItemValues')->where('quote_id',$id)->get()->groupBy('category_id');
        $quotationZoneManage = QuotationZoneManage::where('quotation_id', $quote->quotation_id)->get();

        $groupedItems = $quoteItems->map(function ($group) {
            return $group->sum('amount');
        });

        return view('backend.quotes.edit', compact('quote','quotation','quotations','externalMenus','organization','quoteItems','payments','terms','bank','categories','termInfo','groupedItems','quotationZoneManage'));
    }

    public function templateEdit($id)
    {
        $template = Template::find($id);
        $organization = Organization::latest()->first();
        $quotations = Quotation::latest()->get();
        $externalMenus = TemplateItemValue::where('template_id', $template->id)->distinct()->pluck('header');
        $templateItems = TemplateItem::with('templateItemValues')->where('template_id',$id)->get()->groupBy('category_id');
        $payments = Payment::orderBy('sequence', 'asc')->get();
        $quotation = Quotation::find($template->quotation_id);
        $terms = Term::get();
        $bank = Bank::latest()->first();
        $termInfo = TermInfo::latest()->first();

        $quoteItems = TemplateItem::with('templateItemValues')->where('template_id',$id)->get()->groupBy('category_id');
        $groupedItems = $quoteItems->map(function ($group) {
            return $group->sum('amount');
        });


        return view('backend.quotes.template-edit', compact('groupedItems','template','quotation','quotations','externalMenus','organization','templateItems','payments','terms','bank','termInfo'));
    }

    public function templatePdf($id)
    {
        $template = Template::find($id);

        if ($template) {
            $templateZoneItems = TemplateItem::with('templateItemValues')
                ->where('template_id', $id)
                ->whereNotNull('sub_category_id')
                ->get()
                ->groupBy(['category_id', 'sub_category_id']);

            // Retrieve TemplateItems with null sub_category_id
            $templateWorkItems = TemplateItem::with('templateItemValues')
                ->where('template_id', $id)
                ->whereNull('sub_category_id')
                ->get()
                ->groupBy(['category_id', 'sub_category_id']);

            if(!$templateZoneItems->isEmpty()) {
                // Merge the two collections, ignoring keys from $templateWorkItems if they exist in $templateZoneItems
                $templateItems = $templateZoneItems->merge($templateWorkItems->except($templateZoneItems->keys()->all()));
            } else {
                $templateItems = $templateWorkItems;
            }


            // $templateItems = TemplateItem::with('templateItemValues')
            //         ->where('template_id', $id)
            //         ->get()
            //         ->groupBy(['category_id', 'sub_category_id']);

            $externalMenus = TemplateItemValue::where('template_id', $template->id)->distinct()->pluck('header');
            $organization = Organization::latest()->first();
    
            $view = view('backend.quotes.template-pdf', compact('template','organization','externalMenus','templateItems'))->render();
    
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'format' => 'A4-L',
                'margin_left' => 4,
                'margin_right' => 0,
                'margin_top' => 4,
                'margin_bottom' => 0,
            ]);
            $mpdf->SetTitle('Quotation');
            $mpdf->WriteHTML($view);
            $mpdf->Output(time() . '-Sheet' . ".pdf", "I");
        } else {
            return redirect()->back();
        }
    }

    public function templateDestroy($id)
    {
        try{
            $template = Template::find($id);
            $template->update(['deleted_by' => auth()->user()->id]);

            foreach ($template->templateItems as $key => $templateItem) {
                $templateItem->update(['deleted_by' => auth()->user()->id]);

                foreach ($templateItem->templateItemValues as $key => $templateItemValue) {
                    $templateItemValue->update(['deleted_by' => auth()->user()->id]);
                    $templateItemValue->delete();
                }

                $templateItem->delete();
            }

            $template->delete();


            return redirect()->route('template')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function quoteBank($id)
    {
        $quote = Quote::find($id);
        $quote->quotation->update([
            'active_bank' => 1
        ]);
        return redirect()->back()->withMessage('Successful delete :)');
    }

    public function templateItemDelete($id)
    {
        try{
            $templateItem = TemplateItem::find($id);
            $templateItem->update(['deleted_by' => auth()->user()->id]);
            $templateItem->delete();

            return redirect()->back()->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function quotationItemZoneDelete($quotationId, $quoteId, $categoryId, $zoneId)
    {
        try{
            $quoteItem = QuoteItem::where('quote_id', $quoteId)->where('sub_category_id', $zoneId)->first();

            $quotationZoneManage = QuotationZoneManage::create([
                'quotation_id'      => $quotationId,
                'category_id'       => $categoryId,
                'sub_category_id'   => $zoneId
            ]);
            $quotationZoneManage->update(['created_by' => auth()->user()->id]);

            if($quoteItem != null){
                $quoteItem->update(['deleted_by' => auth()->user()->id]);
                $quoteItem->delete();
            }


            return redirect()->back()->withMessage('Successful delete :)');
        }catch(QueryException $e){
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}