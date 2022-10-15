<!-- IMPORT WITH MODAL -->
<div class="modal fade" id="modalImportKbg" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >

            <div class="modal-header">
                <h4 class="modal-title">Import Data Umat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>Upload file data umat yang akan diimport pada database. Harap Menggunakan format template yang sudah disediakan. <br> Klik <a href="{{url('/umat/DownloadExcelKbg')}}">Disini</a> Untuk Mendownload Template Excel</p>
                <form role="form" method="Post" action="{{ url('umat/ImportUmatKbg') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <div class="form-group">
                        <input type="file" class="form-control" id="excelkbg" name="excelkbg" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>