<div class="margined">
    <?php if($pass[0]): ?>
        <div class="auth">
            <p id="page-id" style="display: none;"><?=$pass[0]?></p>
        </div>
        <div class="data"></div>
    <?php else: ?>
        <h3>403 Forbidden</h3>
        <p>Hey. Uh. What's up? Sorry. Wasn't expecting to see you here.</p>
    <?php endif; ?>
</div>