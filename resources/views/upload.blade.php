@extends('layouts.master')
    
@section('main-content')

<div class="container mt-5">
    <form action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">
        <h3 class="text-center mb-5">Upload Your File</h3>
        @csrf
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-group margin-top-20">
            <label for="import" class="control-label">Upload CSV file</label>
            <input type="file" name="file" id="file" class="form-control" id="chooseFile">
        </div>

        <button type="submit" name="submit"  onclick="showLoader()" class="btn btn-primary btn-block mt-4">
            Upload Files
        </button>
    </form>

    <div id="loader" class="invisible">
        <img style="
        position:absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        margin:auto;" src="{{url('/images/loader.gif')}}" alt="loader" />
    </div> 
</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script type="text/javascript">

    $(function () {

        $('#file').dropify({
            maxFileSize: '1G',
            allowedFileExtensions: ['csv'],
            tpl: {
                filename: ''
            }
        });


    })

    function showLoader() {
        $("#loader").removeClass('invisible');
    }
    

</script>

