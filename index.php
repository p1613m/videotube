<?php
include 'includes/header.php';
?>

<h1>Videos</h1>
<div id="videos" style="display: flex;justify-content: space-between;width: 800px;flex-wrap: wrap;gap: 10px">
    <?php
    $videosCount = $db->query('SELECT * FROM videos')->rowCount();
    $videos = $db->query('SELECT * FROM videos ORDER BY RAND() LIMIT 10')->fetchAll();
    foreach ($videos as $video):
        $video = prepareVideo($video);
        ?>

        <div style="margin-bottom: 20px;" data-id="<?= $video['id'] ?>">
            <a href="video.php?id=<?= $video['id'] ?>">
                <img src="<?=$video['cover_path']?>" alt="" style="display: block;width: 150px;">
                <b><?=$video['name']?></b><br>
                <u><?=$video['channel']['name']?></u>
            </a>
        </div>

    <?php endforeach; ?>
</div>
<?php if($videosCount > count($videos)): ?>
    <button onclick="loadMore()" id="button">Load more</button>
<?php endif; ?>

    <script>
        const loadMore = () => {
            const videos = document.querySelectorAll('div[data-id]');
            const videosEl = document.querySelector('#videos');
            const buttonEl = document.querySelector('#button');

            let videoIds = [];
            videos.forEach(video => {
                videoIds.push(video.getAttribute('data-id'));
            });

            fetch('paginate.php?ids=' + videoIds.join(','))
                .then(r => r.json())
                .then(result => {
                    if(result.count <= 0) {
                        buttonEl.remove();
                    }

                    result.videos.forEach(video => {
                        videosEl.innerHTML += `
                        <div style="margin-bottom: 20px;" data-id="${video.id}">
                            <a href="video.php?id=${video.id}">
                                <img src="${video.cover_path}" alt="" style="display: block;width: 150px;">
                                <b>${video.name}</b><br>
                                <u>${video.channel.name}</u>
                            </a>
                        </div>
                        `;
                    })
                });
        }
    </script>

<?php
include 'includes/footer.php';