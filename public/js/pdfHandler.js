$(document).ready(function () {
    // Immediately hide the modal on page load as a precaution
    $('#pdfPreviewModal').hide();
    
    // Trigger PDF preview on button click
    $('#pdfPreviewButton').on('click', function () {
        generateAndShowPdfPreview();
    });

    // Close modal when clicking the close button
    $(document).on('click', '.pdf-preview-close', function () {
        $('#pdfPreviewModal').hide();
    });

    // Close modal on escape key press
    $(document).on('keydown', function (event) {
        if (event.key === "Escape") {
            $('#pdfPreviewModal').hide();
        }
    });

    // Close modal when clicking outside the preview area
    $(document).on('click', '#pdfPreviewModal', function (event) {
        if ($(event.target).is('#pdfPreviewModal')) {
            $(this).hide();
        }
    });

    // Close modal when clicking the close button
    $(document).on('click', '.close', function () {
        $('#pdfPreviewModal').hide();
    });


    // Handle PDF download on button click within the modal
    $(document).on('click', '#downloadPdfButton', function () {
        if(window.currentPdfBlobUrl) {
            // Use the current PDF blob URL to download the PDF
            var a = document.createElement('a');
            a.href = window.currentPdfBlobUrl;
            a.download = 'table-content.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });
});

function generateAndShowPdfPreview() {
    var element = document.getElementById('editableTable'); // Adjust the ID as needed

    html2canvas(element).then(canvas => {
        var imgData = canvas.toDataURL('image/png');
        var pdf = new jspdf.jsPDF({
            orientation: 'landscape',
        });

        var imgWidth = 210; // A4 size in mm
        var pageHeight = 295;  // A4 size in mm
        var imgHeight = canvas.height * imgWidth / canvas.width;
        var heightLeft = imgHeight;

        var position = 0;

        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        var pdfBlobUrl = pdf.output('bloburl');

        // Store the blob URL for download
        window.currentPdfBlobUrl = pdfBlobUrl;

        // Display in modal
        displayPdfInModal(pdfBlobUrl);
    });
}

function displayPdfInModal(blobUrl) {
    $('#pdfPreviewModal').hide();
    // Create or select the modal HTML
    var $modal = $('#pdfPreviewModal');
    if ($modal.length === 0) {
        // If the modal doesn't exist, create it
        $modal = $('<div id="pdfPreviewModal" class="pdf-preview-modal">')
            .append('<div class="pdf-preview-content"><span class="pdf-preview-close">&times;</span><iframe style="width:100%;height:100%;"></iframe><button id="downloadPdfButton">Download PDF</button></div>')
            .appendTo('body');
        // Apply styles from the previous CSS example here
    }

    // Set the iframe src to the PDF blob URL and show the modal
    $modal.find('iframe').attr('src', blobUrl);
    $modal.show();
}
