<?php include('Header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Employee Roles</h3>
                </div>
                <div class="card-body">
                    <!-- Add Role Button -->
                    <div class="row mb-3">
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> New Role
        </button>
    </div>
</div>

<!-- Table to Manage Roles -->
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Role Name</th>
                        <th>Role Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Row (this can be dynamically populated from a database) -->
                    <tr>
                        <td>1</td>
                        <td>Manger</td>
                        <td>Administrator</td>
                        <td>
                            <button class="btn btn-info btn-sm" title="Edit"> Edit
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-secondary btn-sm" title="Clone"> Clone
                                <i class="fas fa-clone"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" title="Blocked Pages"> Blocked Pages
                                <i class="fas fa-ban"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" title="Delete"> Delete
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Employee</td>
                        <td>Employee</td>
                        <td>
                            <button class="btn btn-info btn-sm" title="Edit">Edit
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-secondary btn-sm" title="Clone">Clone
                                <i class="fas fa-clone"></i>
                            </button>
                            <button class="btn btn-warning btn-sm" title="Blocked Pages">Blocked Pages
                                <i class="fas fa-ban"></i>
                            </button>
                            <button class="btn btn-danger btn-sm"  title="Delete">Delete
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- More rows can go here -->
                </tbody>
            </table>
        </div>
    </div>
</div>


                </div>
            </div>
        </div>
    </div>
</div>

<?php include('Footer.php'); ?>

