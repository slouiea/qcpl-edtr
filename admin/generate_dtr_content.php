<h1>Generate Employee DTR</h1>
<form method="post" class="form-inline mb-3">
    <div class="form-group mr-2">
        <label for="branch" class="mr-2">Sort by Branch</label>
        <select class="form-control" id="branch" name="branch">
            <option value="">All Branches</option>
            <?php foreach ($branches as $branch): ?>
                <option value="<?php echo $branch; ?>"><?php echo $branch; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group mr-2">
        <label for="search_employee" class="mr-2">Search Employee</label>
        <input type="text" class="form-control" id="search_employee" name="search_employee" placeholder="Enter employee name">
    </div>
    <div class="form-group mr-2">
        <label for="month" class="mr-2">Month</label>
        <select class="form-control" id="month" name="month">
            <option value="">Select Month</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?php echo $m; ?>" <?php echo $selected_month == $m ? 'selected' : ''; ?>>
                    <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="form-group mr-2">
        <label for="year" class="mr-2">Year</label>
        <select class="form-control" id="year" name="year">
            <option value="">Select Year</option>
            <?php for ($y = date('Y') - 2; $y <= date('Y'); $y++): ?>
                <option value="<?php echo $y; ?>" <?php echo $selected_year == $y ? 'selected' : ''; ?>>
                    <?php echo $y; ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary" name="generate_dtr">Generate</button>
</form>

<?php if (!empty($employees_filtered)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Branch</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
$selected_month = $_POST['month'] ?? date('n'); 
$selected_year = $_POST['year'] ?? date('Y'); 
?>
            <?php foreach ($employees_filtered as $employee): ?>
                <tr>
                    <td><?php echo $employee['employee_id']; ?></td>
                    <td><?php echo $employee['employee_name']; ?></td>
                    <td><?php echo $employee['branch']; ?></td>
                    <td>
                        <a href="excelmaker.php?month=<?php echo $selected_month; ?>&year=<?php echo $selected_year; ?>&employee_id=<?php echo $employee['employee_id']; ?>" class="btn btn-info btn-sm" target="_blank">View DTR</a>
                        <a href="excelmaker.php?download=csv&month=<?php echo $selected_month; ?>&year=<?php echo $selected_year; ?>&employee_id=<?php echo $employee['employee_id']; ?>" class="btn btn-success btn-sm" target="_blank">Download CSV</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No employees found for the selected criteria.</p>
<?php endif; ?>