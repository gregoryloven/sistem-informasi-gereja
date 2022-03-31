<form role="form" method='POST' action="{{ url('lingkungans/'.$data->id )}}" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Lingkungan</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
        <div class="form-group">
                <label >Paroki</label>
                <select class="form-control" id='paroki_id' name='paroki_id'>
                <option value="{{ $data->Paroki->id }}">{{ $data->Paroki->nama }}</option>
                @foreach($par as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label >Nama</label>
                <input type="hidden" class="form-control" id='id' name='id' placeholder="Type your name" value="{{$data->id}}">
                <input type="text" class="form-control" id='nama' name='nama' placeholder="Nama" value="{{$data->nama}}">
            </div>
            <div class="form-group">
                <label >Batasan Wilayah</label>
                <input type="text" class="form-control" id='batasan_wilayah' name='batasan_wilayah' placeholder="Batasan Wilayah" value="{{$data->batasan_wilayah}}">
            </div>
      </div>
    </div>
</div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-info">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div>
</form>