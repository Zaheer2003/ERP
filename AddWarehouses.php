<?php 
include('Header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Warehouse Information</h3>
                </div>
                <div class="card-body">
                    <form>
                        <!-- Name field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name">
                        </div>

                        <!-- Shipping Address field -->
                        <div class="mb-3">
                            <label for="shippingAddress" class="form-label">Shipping Address</label>
                            <input type="text" class="form-control" id="shippingAddress" placeholder="Enter Shipping Address">
                        </div>

                        <!-- Status field -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>

                        <!-- Primary checkbox -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="primary">
                            <label class="form-check-label" for="primary">Primary</label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Permissions Section -->
            <div class="card">
                <div class="card-header">
                    <h3>Permissions</h3>
                </div>
                <div class="card-body">
                    <form>
                        <!-- View Permission -->
                        <div class="mb-3">
                            <label for="viewPermission" class="form-label">View</label>
                            <select class="form-select" id="viewPermission">
                                <option value="everyone">Everyone</option>
                            </select>
                        </div>

                        <!-- Create Invoices Permission -->
                        <div class="mb-3">
                            <label for="createInvoicesPermission" class="form-label">Create Invoices</label>
                            <select class="form-select" id="createInvoicesPermission">
                                <option value="everyone">Everyone</option>
                            </select>
                        </div>

                        <!-- Update Stock Permission -->
                        <div class="mb-3">
                            <label for="updateStockPermission" class="form-label">Update Stock</label>
                            <select class="form-select" id="updateStockPermission">
                                <option value="everyone">Everyone</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
// Include the footer
include 'Footer.php';
?>


