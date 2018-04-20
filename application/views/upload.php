<!DOCTYPE HTML>

<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="CodeIgniter Photoupload">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Upload Image</title>
        <meta name="author" content="Gopal Gautam">
        <script src="https://code.jquery.com/jquery-1.9.1.min.js" integrity="sha256-wS9gmOZBqsqWxgIVgA8Y9WcQOa7PgSIX+rPA0VL2rbQ=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    </head>
    <body>
        <div class="container">
        <h5 class="text-success text-center"><a href="#" id="event-scanned-docs"> Scanned Docs</a></h5>
        <hr />
        <br />
        <div class="container-fluid">
            <div class="row" id="upload-reg-sheet">
                <div class="col-md-6">
                    <div class="panel panel-default" data-identifier="registration_attendance_sheet">
                        <div class="panel-heading">Registration/Attendance Sheet</div>
                        <div class="actions">
                            <i class="glyphicon glyphicon-cloud-upload" id="upload-btn" ></i>
                            <i class="glyphicon glyphicon-plus" id="add-btn" ></i>
                            <i class="glyphicon glyphicon-refresh" data-perform="panel-refresh"></i>
                            <i class="glyphicon glyphicon-resize-full"></i>
                            <i class="glyphicon  glyphicon-chevron-down"></i>
                            <i class="glyphicon glyphicon-remove"></i>
                        </div>
                        <div class="panel-body">
                            <img class="img img-responsive" src="http://via.placeholder.com/400?text=upload+registration+sheet" />
                            <h4><b>Image Caption</b></h4>
                            <p>Image description</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="upload-training-schedule">
                <div class="col-md-6">
                    <div class="panel panel-default" data-identifier="training_schedule">
                        <div class="panel-heading">Training Schedule</div>
                        <div class="actions">
                            <i class="glyphicon glyphicon-cloud-upload" id="upload-btn" ></i>
                            <i class="glyphicon glyphicon-plus" id="add-btn" ></i>
                            <i class="glyphicon glyphicon-refresh" data-perform="panel-refresh"></i>
                            <i class="glyphicon glyphicon-resize-full"></i>
                            <i class="glyphicon  glyphicon-chevron-down"></i>
                            <i class="glyphicon glyphicon-remove"></i>
                        </div>
                        <div class="panel-body">
                            <img class="img img-responsive" src="http://via.placeholder.com/400?text=upload+training+Schedule" />
                            <h4><b>Image Caption</b></h4>
                            <p>Image description</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="upload-photos">
                <div class="col-md-6">
                    <div class="panel panel-default" data-identifier="representative_photo">
                        <div class="panel-heading">Representative Photo</div>
                        <div class="actions">
                            <i class="glyphicon glyphicon-cloud-upload" id="upload-btn" ></i>
                            <i class="glyphicon glyphicon-plus" id="add-btn" ></i>
                            <i class="glyphicon glyphicon-refresh" data-perform="panel-refresh"></i>
                            <i class="glyphicon glyphicon-resize-full"></i>
                            <i class="glyphicon  glyphicon-chevron-down"></i>
                            <i class="glyphicon glyphicon-remove"></i>
                        </div>
                        <div class="panel-body">
                            <img class="img img-responsive" src="http://via.placeholder.com/400?text=upload+representative+photo" />
                            <h4><b>Image Caption</b></h4>
                            <p>Image description</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default" data-identifier="other_photo">
                        <div class="panel-heading">Other Photo</div>
                        <div class="actions">
                            <i class="glyphicon glyphicon-cloud-upload" id="upload-btn" ></i>
                            <i class="glyphicon glyphicon-plus" id="add-btn" ></i>
                            <i class="glyphicon glyphicon-refresh" data-perform="panel-refresh"></i>
                            <i class="glyphicon glyphicon-resize-full"></i>
                            <i class="glyphicon  glyphicon-chevron-down"></i>
                            <i class="glyphicon glyphicon-remove"></i>
                        </div>
                        <div class="panel-body">
                            <img class="img img-responsive" src="http://via.placeholder.com/400?text=upload+other+photo" />
                            <h4><b>Image Caption</b></h4>
                            <p>Image description</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <!-- Loading modal for image upload -->
<div class="modal fade image-upload-loading-modal" id="upload-loading-modal" tabindex="-1" role="dialog" aria-labelledby="uploadLoadingModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="../img/loading.gif"/>
            </div>
        </div>
    </div>
</div>

<!-- Modal For image upload -->
<div class="modal fade" id="scanned-doc-modal" tabindex="-1" role="dialog" aria-labelledby="scannedDocModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--                <h5 class="modal-title" id="scannedDocModal">Upload Form</h5>-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="well well-sm col-md-10 col-md-offset-1">
                        <form role="form" method="post" id="scanned-doc-form">
                            <input type="hidden" name="field_name" id="fieldname-identifier" />
                            <input type="hidden" name="existing_photo_guid" id="existing-photo-guid" />
                            <div class="form-group">
                                <label class="control-label" for="caption">Caption</label>
                                <textarea class="form-control" name="caption" id="image-caption"></textarea>
    <!--                            <input type="text" name="caption" class="form-control" id="image-caption" placeholder="Enter Caption">-->
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="description">Description</label>
                                <textarea class="form-control" name="description" id="image-description"></textarea>
    <!--                            <input type="text" name="description" class="form-control" id="image-description" placeholder="Password">-->
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="scanned-file">File</label>
                                <input type="file" name="scanned_doc" class="form-control" id="scanned-file">
                                <p class="help-block">Upload your scanned document.</p>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Endof Image Modal upload -->
</body>
<script>
    var event_id=521;

    //Panel Controls

    $('.panel .glyphicon-resize-full').click(function() {
        var panel = $(this).closest('.panel');
        panel.toggleClass('panel-fullscreen');
        $(this).toggleClass('glyphicon-resize-full glyphicon-resize-small');
        $('body').toggleClass('fullscreen-widget-active')
    });

    $(document).on("click", ".actions > .glyphicon-chevron-down", function() {
        $(this).parent().next().slideToggle("fast");
        $(this).toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });

    $(document).on("click", ".actions > .glyphicon-remove", function() {
        var $panel = $(this).parents('.panel-default');
        var image_fieldname = $panel.data('identifier');
        var image_guid = $panel.data('photo-identifier');
        if(event_id !== undefined && image_fieldname !== undefined && image_guid !== undefined)
        {
            var user_delete_confirm = confirm("Are you sure you want to delete this photo?");
            if (!user_delete_confirm) {
                return;
            }
            $.ajax({
                url: 'deletePhoto_aysnc/'+event_id+'/'+image_fieldname+'/'+image_guid,
                method: 'POST',
                success: function(resp) {
                    console.log(resp);
                },
                error: function(err) {
                    alert('error');
                    console.log(err);
                    return;
                }
            });
        }
        $(this).parent().parent().parent().fadeOut();
    });

    $(document).on("click", ".actions > #upload-btn", function() {
        var image_identifier = $(this).parents('.panel').data('identifier');
        var image_caption = $(this).parents('.actions').siblings('.panel-body').find("h4").text();
        if(image_caption == undefined)
            image_caption = $(this).parents('.actions').siblings('.panel-heading').text();
        var image_description = $(this).parents('.actions').siblings('.panel-body').find("p").text();
        if(image_description != undefined )
            $("#image-description").val(image_description);
        var existing_photo_guid = $(this).parents('.panel').attr('data-photo-identifier');
        if(existing_photo_guid != undefined || existing_photo_guid !== '') {
            $("#existing-photo-guid").val(existing_photo_guid);
        }
        console.log(image_identifier);
        $("#fieldname-identifier").val(image_identifier);
        $("#image-caption").val(image_caption);
        $('#scanned-doc-modal').modal()
    });

    $(document).on("click", ".actions > #add-btn", function() {
       var self = this;
       var $self = $(self);
       var $par = $self.parents('.col-md-6');
       console.log($par);
        $new_panel_par = $par.clone();
        $new_panel_par.find('.panel-default').removeAttr('data-photo-identifier');
        $new_panel_par.find('img').attr('src', '');
        $new_panel_par.find('b').text('');
        $new_panel_par.find('p').text('');
        $new_panel_par.appendTo($panel_par.parent());
       //$par.clone().appendTo($par.parent());
    });

    $("#scanned-doc-form").submit(function (event) {
        event.preventDefault();
        var $upload_modal = $("#upload-loading-modal");
        $('#scanned-doc-modal').modal('hide');
        $upload_modal.modal('show');
        var fieldname_identifier = $("#fieldname-identifier").val();
        var formData = new FormData(this);
        formData.append('event_id', event_id);
        formData.append(fieldname_identifier, $('input[name=scanned_doc]')[0].files[0]); //Replace with formData.get..
        $.ajax({
            method: 'POST',
            url: 'upload_scanned_doc',
            contentType: false,
            processData: false,
            data: formData,
            success: function(resp) {
                console.log("Response got");
                $upload_modal.modal('hide');
                updatePanel(fieldname_identifier, resp.guid, resp.caption, resp.description);
            },
            error: function(err) {
                $upload_modal.modal('hide');
                alert("Error");
                console.log(err);
            }
        });
    });
    
    $(document).ready(function() {
        $.get('getPhotos_async/'+event_id, function(resp) {
            for(var idx in resp) {
                var photo = resp[idx];
                updatePanel(photo.field_name, photo.guid, photo.caption, photo.description);
            }
        })
    });

    function updatePanel(fieldname_identifier, photo_guid, image_caption, image_description)
    {
        var $panel_by_guid = $('div[data-photo-identifier='+photo_guid+']');
        if($panel_by_guid.length) {
            //the panel exist need to replace the content only
            $panel_by_guid.find('img').attr('src', '');
            $panel_by_guid.find('img').attr('src', '../photo/'+photo_guid);
            $panel_by_guid.find('b').text(image_caption);
            $panel_by_guid.find('p').text(image_description);
            $panel_by_guid.attr('data-photo-identifier', photo_guid);
            return;
        }
        var $panel = $('div[data-identifier='+fieldname_identifier+']');
        if ($panel.length !== 1) {
            $panel = $($panel[$panel.length - 1]);
        }
        $panel.find('img').attr('src', '../photo/'+photo_guid);
        $panel.find('b').text(image_caption);
        $panel.find('p').text(image_description);

        $panel.attr('data-photo-identifier', photo_guid);

        $panel_par = $panel.parent();
        $new_panel_par = $panel_par.clone();
        $new_panel_par.find('.panel-default').removeAttr('data-photo-identifier');
        $new_panel_par.find('img').attr('src', '');
        $new_panel_par.find('b').text('');
        $new_panel_par.find('p').text('');
        $new_panel_par.appendTo($panel_par.parent());

    }

</script>
</html>