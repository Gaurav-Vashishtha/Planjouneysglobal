<div class="card p-4">
    <h4>Currency Settings</h4>
    <hr>

    <form action="<?= base_url('admin/currency/update'); ?>" method="POST">
        
        <div class="mb-3">
            <label>1 INR = ? USD</label>
            <input type="number" step="0.0001" name="usd_rate" class="form-control"
                   value="<?= $currency->usd_rate; ?>" required>
        </div>

        <div class="mb-3">
            <label>1 INR = ? AED (Dubai Currency)</label>
            <input type="number" step="0.0001" name="aed_rate" class="form-control"
                   value="<?= $currency->aed_rate; ?>" required>
        </div>


        <button class="btn btn-primary">Save</button>
    </form>
</div>