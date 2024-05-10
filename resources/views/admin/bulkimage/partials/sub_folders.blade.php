<div class="row" >
    <div class="col-lg-12 p-5">

        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
        </div>
              <div class="row">
                  <div class="col-lg-12">
                      <span style="margin-top:10px;"><a class="btn btn-primary" id="create-folder">{{ __("Create Folder") }}</a></span>
                      <span style="margin-top:10px;"><a class="btn btn-primary" id="upload-img">{{ __("Upload") }}</a></span>
                      <span style="margin-top:10px;"><a class="btn btn-danger float-right" id="delete-img">{{ __("Delete") }}</a></span>
                  </div>
              </div>
              <hr>
              <div class="row">
                <div class="mr-breadcrumb">
                    <div class="row">
                        <div class="col-lg-12">
                                <ul class="links">
                                    <li>
                                        <a href="javascript:;">{{ __("Public") }} </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin-bulk-image') }}">{{ __("Images") }} </a>
                                    </li>
                                </ul>
                        </div>
                    </div>
                </div>
              </div>
              <div class="row" >
                @foreach($files as $file=>$f)
                    <div class="card  card-sm col-md-2 col-12 my-3 folder" style="cursor: pointer">
                        @php($filePath=$files[$file]["dirname"].'/'.$files[$file]["basename"])
                        <img class="card-img-top " src="{{asset('assets/images/admins/folder.png')}}" alt="" >
                        <div class="card-body">
                            <span path="{{$filePath}}" title="{{$files[$file]['filename']}}" class="path">{{$files[$file]['filename']}}</span>
                        </div>
                    </div>
                @endforeach
                @foreach($allimg as $file=>$f)
                <div class="card card-sm col-md-2 col-12 my-3 file" style="cursor: pointer">
                    @php($filePath=$allimg[$file]["dirname"].'/'.$allimg[$file]["basename"])
                    <input type="checkbox" name="check[]" data-path="{{$filePath}}" class="check-delete mb-1" style="display: none">
                    <img class="card-img-top" src="{{asset(explode('..//',$filePath)[1])}}" alt="" width="100" height="100">
                    <div class="card-body text-compress">
                        <span path="{{$filePath}}" title="{{$allimg[$file]['filename']}}" class="path">{{$allimg[$file]['filename']}}</span>
                    </div>
                </div>
                @endforeach
              </div>
    </div>
</div>
<div class="modal" id="folder-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">New Folder</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{route('create-folder')}}" method="POST">
                @csrf
                <label for="">Folder Name</label>
                <input type="text" required name="name" class="form-control">
                <input type="hidden" name="path" id="" value="{{$curPath}}">
                <button class="btn btn-success btn-sm">Create</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
<div class="modal" id="upload-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Upload Images</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{route('upload-img')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">Upload Bulk Images</label>
                <input type="file" name="imgs[]" id="file" class="form-control" multiple accept="Image/*" onchange="return fileValidation()">
                <input type="hidden" name="path" id="" value="{{$curPath}}">
                <button class="btn btn-success btn-sm mt-1">Upload</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
