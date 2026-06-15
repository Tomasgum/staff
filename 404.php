<?php get_header(); ?>

<div style="min-height:60vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:80px 24px;">
    <div>
        <div style="font-family:var(--font-display);font-size:8rem;font-weight:900;color:var(--accent);line-height:1;">404</div>
        <h1 style="font-size:2rem;color:white;margin:16px 0 12px;">Puslapis nerastas</h1>
        <p style="color:var(--text-muted);margin-bottom:32px;">Atsiprašome, tokio puslapio neradome.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary btn--lg">Grįžti į pradžią</a>
    </div>
</div>

<?php get_footer(); ?>
