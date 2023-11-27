$(document).ready(function() {
    $("#tanggal_nonton").datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    });
});

function validateDate() {
    var dateEntered = document.getElementById('tanggal_nonton').value;

    return true;
}

function previewPoster(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function () {
        var posterBox = document.querySelector('.poster');
        posterBox.style.backgroundImage = 'url(' + reader.result + ')';
        posterBox.style.backgroundSize = 'cover';
        posterBox.style.backgroundPosition = 'center';
        
        input.classList.add('image-uploaded');
    };

    reader.readAsDataURL(input.files[0]);
}

$(document).ready(function() {
    $('#poster_film').on('change', function(event) {
        previewPoster(event);
    });
});

function deleteReview(id) {
    var confirmDelete = confirm("Are you sure you want to delete the review?");
    if (confirmDelete) {
        window.location.href = "delete_review.php?id_review=" + id;
    }
}

