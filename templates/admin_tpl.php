<div class="margined">
    <?php if($pass[0]): ?>
        <div class="auth">
            <p id="page-id" style="display: none;"><?=$pass[0]?></p>
            <button type="submit" class="admin-auth-ajax">Load!</button>
        </div>
        <div class="data"></div>
    <?php else: ?>
    <a href="/create/">Create a page!</a>
    <?php endif; ?>
</div>