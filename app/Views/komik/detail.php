<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Detail</h1>
            <?php if (session()->getFlashdata('status')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5>Upss Error..</h5>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script type="text/javascript">
                $(window).on('load',function(){
                    $('#staticBackdrop').modal('show');
                });
            </script>

            <?php endif;?>

            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $komik['sampul']; ?>" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul']; ?></h5>
                            <input type="hidden" name="slug" id="slugnya" data-slug="<?= $komik['slug']; ?>"
                                value="<?= $komik['slug']; ?>">
                            <p class="card-text"><?= $komik['penulis']; ?></p>
                            <p class="card-text"><small class="text-muted"><?= $komik['penerbit']; ?></small></p>

                            <a onclick="edit(<?= $komik['id']; ?>)" class="btn btn-warning">Edit</a>
                            <!-- <a href="/komik/delete/<?= $komik['id']; ?>" class="btn btn-danger">Hapus</a> -->
                            <form action="/komik/<?= $komik['id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">DELETE</button>
                            </form>
                            <br><br>
                            <a href="/komik">Kembali</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tempat_modal"></div>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/komik/update" method="post">
                    <!-- KE AMANAN XSS -->
                    <?= csrf_field(); ?>
                    <!-- KE AMANAN XSS -->

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="hidden" name="id" id="id" value="<?= old('id'); ?>">
                            <input type="hidden" name="slug" id="slug" value="<?= old('slug'); ?>">
                            <input type="text" id="judul" name='judul'
                                class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : '' ; ?>"
                                autofocus value="<?= (old('judul')) ? old('judul') : $komik['judul'] ?>">
                            <div class="invalid-feedback" style="display: block;">
                                <?= $validation->getError('judul'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Penulis</label>
                        <div class="col-sm-10">
                            <input type="text" name='penulis' class="form-control" id="penulis"
                                value="<?= old('penulis'); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Penerbit</label>
                        <div class="col-sm-10">
                            <input type="text" name='penerbit' class="form-control" id="penerbit"
                                value="<?= old('penerbit'); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Sampul</label>
                        <div class="col-sm-10">
                            <input type="text" name='sampul' class="form-control" id="sampul"
                                value="<?= old('sampul'); ?>">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function edit(id) {
    var slug = $('#slugnya').data('slug');
    $.ajax({
        type: "get",
        url: "<?= base_url('komik/edit')?>",
        data: "id=" + id + "&slug=" + slug,
        success: function(hasil) {
            // $('#tempat_modal').html(hasil)
            var datanya = JSON.parse(hasil); //konver hasil api json
            $("#id").val(datanya.id)
            $("#judul").val(datanya.judul)
            $("#penulis").val(datanya.penulis)
            $("#penerbit").val(datanya.penerbit)
            $("#sampul").val(datanya.sampul)
            $("#slug").val(datanya.slug)
            openmodal()
        }
    });
}

function openmodal() {
    $('#staticBackdrop').modal('show');
}
</script>

<?= $this->endSection(); ?>