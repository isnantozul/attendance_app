<!-- Content -->
<main>
    <div class="container text-center">

    <?=form_open("admin/login",["method"=>"post"]);?>
        <div class="form-signin">
        <?php
            // pesan error/sukses
            if($this->session->flashdata('pesan'))
            { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$this->session->flashdata('pesan');?>
                </div>    
            <?php }?>
            <h1 class="h3 mb-3 mt-3 font-weight-normal">Login Admin</h1>
            <label for="inputEmail" class="sr-only">Username</label>
            <input type="text" name="username" id="inputEmail" class="form-control mt-5" placeholder="Username" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control mt-3" placeholder="Password" required="">
            <button class="btn btn-lg btn-primary btn-block mt-5" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">© Destinasi Computindo 2021</p>
        </div>
    <?=form_close();?>
    </form>
    </div>
</main>