<?php
$topics = selectAll('topics');
?>

<div class="fix">
    <div class="sticky">
        <div class="sidebar">
            <div class="section search">
                <form action="tblog_search.php" method="post">
                    <div class="search_btn">                        
                        <input type="text" name="search-term" class="text-input" minlength="3" maxlength="20" placeholder="Cerca...">
                        <button  type="submit" class="btn main btn"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="section topics">
                <h2 class="section-title">Temi degli Articoli</h2>
                <ul>
                <?php foreach ($topics as $topic): ?>
                    <li>
                        <a href="<?php echo BASE_URL . '/tblog_search.php?t_id=' . $topic['id'] . '&name=' . $topic['name'] ?>"><?php echo $topic['name']; ?></a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="scroll_up">
                <a href="#" id="scroll_up" title="" class="btn btn"><i class="fas fa-arrow-up"></i></a>
            </div>
        </div>
    </div>
</div>
