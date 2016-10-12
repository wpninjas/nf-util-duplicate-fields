<div class="<?php if( isset( $classes ) ) echo $classes; ?>">

    <?php if( isset( $title ) ): ?>
        <h2><?php echo $title; ?></h2>
    <?php endif; ?>

    <?php if( isset( $message ) ): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if( isset( $link ) ): ?>
        <p>
            <a class="<?php echo $link[ 'classes' ]; ?>" href="<?php echo $link[ 'href' ]; ?>"><?php echo $link[ 'text' ]; ?></a>
        </p>
    <?php endif; ?>

</div>