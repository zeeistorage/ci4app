<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-3">Daftar Komik</h1>
            <!-- <a href="/komik/create" class="btn btn-primary mb-3">Tambah</a> -->

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#staticBackdrop">
                Tambah Data
            </button>

            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <?php endif;?>
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

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahdata" action="/komik/save" method="post" enctype="multipart/form-data">
                                <!-- KE AMANAN XSS -->
                                <?= csrf_field(); ?>
                                <!-- KE AMANAN XSS -->

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" name='judul' class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : '' ; ?>" id="judul" autofocus value="<?= old('judul'); ?>">
                                        <div class="invalid-feedback" style="display: block;">
                                            <?= $validation->getError('judul'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Penulis</label>
                                    <div class="col-sm-10">
                                        <input type="text" name='penulis' class="form-control" id="penulis" value="<?= old('penulis'); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Penerbit</label>
                                    <div class="col-sm-10">
                                        <input type="text" name='penerbit' class="form-control" id="penerbit" value="<?= old('penerbit'); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Sampul</label>
                                    <div class="col-lg-2-sm-2-cs-2">
                                        <img src="/img/default.jpg" class="img-thumbnail img-preview" style="height: 100px;" >
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="custom-file">
                                            <input type="file" id="sampul" name="sampul" class="custom-file-input <?= ($validation->hasError('sampul')) ? 'is-invalid' : '' ; ?>" onchange="previewimg()" >
                                            <div class="invalid-feedback" style="display: block;">
                                                <?= $validation->getError('sampul'); ?>
                                            </div>
                                            <label class="custom-file-label" for="sampul">Choose file</label>
                                        </div>
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
            <!--  PREVIEW IMAGE -->
            <script>
                function previewimg(){
                    const sampul = document.querySelector('#sampul')
                    const sampulLabel = document.querySelector('.custom-file-label')
                    const imgPreview = document.querySelector('.img-preview')

                    sampulLabel.textContent = sampul.files[0].name

                    const filesampul = new FileReader()
                    filesampul.readAsDataURL(sampul.files[0])

                    filesampul.onload = function(e){
                        imgPreview.src = e.target.result
                    }
                }
            </script>

            <!-- <script>
                $("#tambahdata").submit(function (e) { 
                    e.preventDefault();
                    var data = $("#tambahdata").serialize()
                    $.ajax({
                        type: "post",
                        url: "<?=base_url('/komik/save')?>",
                        data:  new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        
                        success: function (response) {
                            
                        }
                    });
                });
            </script> -->

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i =1;
                    foreach ($komik as $k) : 
                    ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><img src="/img/<?=$k['sampul']?>" class="sampul" alt=""></td>
                        <td><?= $k['judul']; ?></td>
                        <td>
                            <a href="/komik/<?= $k['slug'] ?>" class="btn btn-success">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>