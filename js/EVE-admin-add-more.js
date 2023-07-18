$(document).ready(function(){
    $('#addCriterion').click(function(e){
        e.preventDefault();
        $("#criterionForm").append(`<div id="criterionField" class="row form-fields appended">  
                                        <div class="criterion col-9">
                                            <input type="text" class="form-control" id="criterionInput" name="criterion[]" placeholder="Enter Criterion" required>
                                        </div>
                                        <div class="percent col-2">
                                            <input type="text" class="form-control" id="criterionPercentInput" name="percentage[]" placeholder="Percentage" maxlength="3" required >
                                        </div>
                                        <div class="col-1 d-flex align-items-center justify-content-center">
                                            <div class="x-icon" id="removeBtn"><i class='bx bxs-trash danger-color'></i></div>
                                        </div>
                                    </div>`);
        updateTotalPercentage();              
    })

    $(document).on('click', '#removeBtn', function(e){
        e.preventDefault();
        let criterion = $(this).parent().parent();
        $(criterion).remove();
        updateTotalPercentage();
    });
});