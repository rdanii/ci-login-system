<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
  <div class="row">
    <div class="col-lg">

      <?php if (validation_errors()) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= validation_errors() ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php } ?>
      <?= form_error('menu', '<div class="alert alert-danger alert-dismissible fade show" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>') ?>
      <?= $this->session->flashdata('message'); ?>

      <a class="btn btn-primary mb-3" href="" data-toggle="modal" data-target="#newSubmenuModal">Add New Submenu</a>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Menu</th>
            <th scope="col">Url</th>
            <th scope="col">Icon</th>
            <th scope="col">Active</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1 ?>
          <?php foreach ($submenu as $row) { ?>
            <tr>
              <th scope="row"><?= $i++ ?></th>
              <td><?= $row['title'] ?></td>
              <td><?= $row['menu'] ?></td>
              <td><?= $row['url'] ?></td>
              <td><?= $row['icon'] ?></td>
              <td><?= $row['is_active'] ?></td>
              <td>
                <a class="badge badge-warning" href="" data-toggle="modal" data-target="#editModal<?= $row['id'] ?>">Edit</a>
                <a class="badge badge-danger" href="<?= base_url('menu/deleteSubMenu/') . $row['id'] ?>" onclick="return confirm('Do you want to delete?')">Delete</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Add New Menu Modal -->
<div class="modal fade" id="newSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubmenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newSubmenuModalLabel">Add New Submenu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu/submenu') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
          </div>
          <div class="form-group">
            <select name="menu_id" id="menu_id" class="form-control">
              <option value="">Select menu</option>
              <?php foreach ($menu as $row) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['menu'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
              <label class="form-check-label" for="is_active">
                Active?
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<?php foreach ($submenu as $row) { ?>
  <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Menu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?= base_url('menu/editSubmenu') ?>" method="post">
            <div class="form-group">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <label>Title</label>
              <input type="text" class="form-control" id="title" name="title" value="<?= $row['title'] ?>">
            </div>
            <div class="form-group">
              <label>Menu</label>
              <input type="text" class="form-control" id="menu_id" name="menu_id" value="<?= $row['menu_id'] ?>">
            </div>
            <div class="form-group">
              <label>Url</label>
              <input type="text" class="form-control" id="url" name="url" value="<?= $row['url'] ?>">
            </div>
            <div class="form-group">
              <label>Icon</label>
              <input type="text" class="form-control" id="icon" name="icon" value="<?= $row['icon'] ?>">
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="<?= $row['is_active'] ?>" id="is_active" name="is_active" checked>
                <label class="form-check-label" for="is_active">
                  Active?
                </label>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>