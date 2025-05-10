<?php
if (!isset($search_keyword)) {
    $search_keyword = '';
}
if (!isset($items_per_page)) {
    $items_per_page = 10; // Default value
}
?>
<h1>Manage Branches</h1>
<form method="post" class="form-inline mb-3">
    <div class="form-group mr-2">
        <label for="search_keyword" class="mr-2">Search</label>
        <input type="text" class="form-control" id="search_keyword" name="search_keyword" value="<?php echo $search_keyword; ?>">
    </div>
    <div class="form-group mr-2">
        <label for="items_per_page" class="mr-2">Items Per Page</label>
        <input type="number" class="form-control" id="items_per_page" name="items_per_page" value="<?php echo $items_per_page; ?>" min="1">
    </div>
    <button type="submit" class="btn btn-primary">Apply</button>
    </form>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Branch Name</th>
                <th>Branch Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['branch_name']}</td>";
                    echo "<td>{$row['branch_address']}</td>";
                    echo "<td>
                            <button class='btn btn-warning' data-toggle='modal' data-target='#editBranchModal' data-id='{$row['id']}' data-branch_name='{$row['branch_name']}' data-branch_address='{$row['branch_address']}'>Edit</button>
                            <button class='btn btn-danger' data-toggle='modal' data-target='#deleteBranchModal' data-id='{$row['id']}'>Delete</button>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="page" value="<?php echo $i; ?>">
                        <input type="hidden" name="search_keyword" value="<?php echo $search_keyword; ?>">
                        <input type="hidden" name="items_per_page" value="<?php echo $items_per_page; ?>">
                        <button type="submit" class="page-link"><?php echo $i; ?></button>
                    </form>
                </li>
                
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- Add Branch Modal -->
<div class="modal fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="branches.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBranchModalLabel">Add Branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_branch_name">Branch Name</label>
                        <input type="text" class="form-control" id="add_branch_name" name="branch_name" required>
                    </div>
                    <div class="form-group">
                        <label for="add_branch_address">Branch Address</label>
                        <input type="text" class="form-control" id="add_branch_address" name="branch_address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="create_branch">Add Branch</button>
                </div>
            </form>
            
        </div>
        
    </div>
</div>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addBranchModal">Add Branch</button>


<!-- Edit Branch Modal -->
<div class="modal fade" id="editBranchModal" tabindex="-1" role="dialog" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="branches.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBranchModalLabel">Edit Branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_branch_name">Branch Name</label>
                        <input type="text" class="form-control" id="edit_branch_name" name="branch_name">
                    </div>
                    <div class="form-group">
                        <label for="edit_branch_address">Branch Address</label>
                        <input type="text" class="form-control" id="edit_branch_address" name="branch_address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="edit_branch">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Branch Modal -->
<div class="modal fade" id="deleteBranchModal" tabindex="-1" role="dialog" aria-labelledby="deleteBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="branches.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBranchModalLabel">Delete Branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="id">
                    <p>Are you sure you want to delete this branch?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="delete_branch">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>