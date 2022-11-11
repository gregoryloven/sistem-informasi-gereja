<form role="form" method='POST' action="{{ url('validasiAdminPerkawinan/Update/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Ubah Tanggal & Waktu Perkawinan</h4>
    </div>
    <div class="modal-body">
        @csrf
        <div class="form-body">
            <div class="form-group">
                <label >Tanggal & Waktu Perkawinan (Saat Ini)</label>
                <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
                <input type="text" value="{{tanggal_indonesia($data->tanggal_perkawinan)}}, {{waktu_indonesia($data->tanggal_perkawinan)}} WITA" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label >Tanggal & Waktu Perkawinan (Terbaru)</label>
                <input type="datetime-local" class="form-control" id='tanggal_perkawinan' name='tanggal_perkawinan' min="<?= date('Y-m-d H:i'); ?>">
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>
