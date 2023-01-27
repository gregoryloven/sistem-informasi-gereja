<form role="form" method='POST' action="{{ url('setting/updatekomuni/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Ubah Ketentuan Komuni Pertama</h4>
    </div>
    <div class="modal-body">
        @csrf
        <div class="form-body">
        <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
            <label style='color:red'>*Ketentuan Komuni Pertama</label>
            <div class="form-group">
                <label >Komuni Pertama: Umur lebih dari (Tahun)</label>
                <input type="number" value="{{$data->umur_komuni}}" class="form-control" name='umur_komuni' min="1" required>
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>