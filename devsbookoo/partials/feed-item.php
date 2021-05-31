<?php
require_once 'feed-item-script.php';

$actionPhrase = '';
switch ($feedItem->type) {
    case 'text':
        $actionPhrase = 'fez um post';
        break;
    case 'photo':
        $actionPhrase = 'postou uma foto';
        break;        
}
?>
<div class="box feed-item" data-id="<?=$feedItem->id;?>">
    <div class="box-body">
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href="<?=$base;?>/perfil.php?id=<?=$feedItem->user->id;?>"><img src="<?=$base;?>/media/avatars/<?=$feedItem->user->avatar;?>" /></a>
            </div>
            <div class="feed-item-head-info">
                <a href="<?=$base;?>/perfil.php?id=<?=$feedItem->user->id;?>"><span class="fidi-name"><?=$feedItem->user->name;?></span></a>
                <span class="fidi-action"><?=$actionPhrase;?></span>
                <br/>
                <span class="fidi-date"><?=date('d/m/Y', strtotime($feedItem->created_at));?></span>
            </div>
            <?php if($feedItem->mine): ?>
                <div class="feed-item-head-btn">                
                    <img src="<?=$base;?>/assets/images/more.png" />
                    <div class="feed-item-more-window">
                        <a href="<?=$base;?>/excluir_post_action.php?id=<?=$feedItem->id;?>">Excluir Post</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="feed-item-body mt-10 m-width-20">
            <?php
            switch ($feedItem->type) {
                case 'text':
                    echo nl2br($feedItem->body);
                    break;
                case 'photo':
                    echo '<img = src="'.$base.'/media/uploads/'.$feedItem->body.'" />';
                    break;        
            }
            ?>
        </div>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn <?=$feedItem->liked? 'on' : '' ;?>"><?=$feedItem->likeCount;?></div>
            <div class="msg-btn"><?=count($feedItem->comments);?></div>
        </div>
        <div class="feed-item-comments">
           
            <div class="feed-item-comments-area">
                <?php foreach ($feedItem->comments as $comment) : ?>
                    <div class="fic-item row m-height-10 m-width-20">
                        <div class="fic-item-photo">
                            <a href="<?=$base;?>/perfil.php?id=<?=$comment->id_user;?>"><img src="<?=$base;?>/media/avatars/<?=$comment->user->avatar;?>" /></a>
                        </div>
                        <div class="fic-item-info">
                            <a href="<?=$base;?>/perfil.php?id=<?=$comment->id_user;?>"><?=$comment->user->name;?></a>
                            <?=$comment->body;?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
           
            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <a href="<?=$base;?>/perfil.php"><img src="<?=$base;?>/media/avatars/<?=$userInfo->avatar;?>" /></a>
                </div>
                <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
            </div>

        </div>
    </div>
</div>