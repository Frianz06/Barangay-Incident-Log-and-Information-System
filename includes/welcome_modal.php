<!-- Welcome Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="welcomeModalLabel">Welcome!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Welcome to the Barangay San Francisco Incident Log System!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
// NEW CODE FOR WELCOME MODAL, JQUERY
// $(document).ready(function() {...}); is the jQuery equivalent of 
// document.addEventListener('DOMContentLoaded', ...). 
// It ensures the DOM is fully loaded before running the code.
$(document).ready(function() {
    
    // $('#welcomeModal')[0] is used to select the modal element by its ID ('welcomeModal'). 
    // The [0] is necessary because jQuery returns a jQuery object, but Bootstrap's Modal class 
    // expects a regular DOM element, so we access the first element in the jQuery selection using [0].
    var welcomeModal = new bootstrap.Modal($('#welcomeModal')[0]);

    // Show the modal once the DOM is ready
    welcomeModal.show();
});


  // FOR SAFE KEEPING, ORIGINAL CODE FOR WELCOME MODAL
  // document.addEventListener('DOMContentLoaded', function() {
  //   var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
  //   welcomeModal.show();
  // });
</script>