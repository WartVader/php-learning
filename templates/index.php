<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="get" autocomplete="off">
    <input class="search-form__input" type="text" name="search" value="<?php if(isset($_GET['search'])):?><?= $_GET['search'] ?><?php endif; ?>" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="index.php" class="tasks-switch__item <?php if(!isset($_GET['filter'])): ?> tasks-switch__item--active<?php endif; ?>">Все задачи</a>
        <a href="index.php?filter=today" class="tasks-switch__item <?php if(isset($_GET['filter']) && $_GET['filter'] == 'today'): ?> tasks-switch__item--active<?php endif; ?>">Повестка дня</a>
        <a href="index.php?filter=tomorrow" class="tasks-switch__item <?php if(isset($_GET['filter']) && $_GET['filter'] == 'tomorrow'): ?> tasks-switch__item--active<?php endif; ?>">Завтра</a>
        <a href="index.php?filter=overdue" class="tasks-switch__item <?php if(isset($_GET['filter']) && $_GET['filter'] == 'overdue'): ?> tasks-switch__item--active<?php endif; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <!--добавить сюда атрибут "checked", если переменная $showCompleteTasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if($showCompleteTasks == true): ?> checked <?php endif;?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php if($showCompleteTasks == true): ?>
        <tr class="tasks__item task task--completed">
            <td class="task__select">
                <label class="checkbox task__checkbox">
                    <input class="checkbox__input visually-hidden" type="checkbox" checked>
                    <span class="checkbox__text">Записаться на интенсив "Базовый PHP"</span>
                </label>
            </td>
            <td class="task__date">10.10.2019</td>
            <td class="task__controls"></td>
        </tr>
    <?php endif;?>
    <?php foreach($tasks as $task): ?>
        <?php if($showCompleteTasks || !$task["status"]): ?>
            <tr class="tasks__item task <?php if( !isMoreOrEquivalent24hours($task["deadline"]) ): ?> task--important <?php endif;?> <?php if( $task["status"] == true ): ?> task--completed <?php endif;?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" <?php if( $task["status"] == true ): ?> checked <?php endif;?> value="<?= $task['id'] ?>">
                        <span class="checkbox__text"><?= htmlspecialchars( $task["name"] ); ?></span>
                    </label>
                </td>
                <td class="task__date"><?= htmlspecialchars( $task["deadline"] ); ?></td>
                <td class="task__controls"></td>
            </tr>
        <?php endif;?>
    <?php endforeach;?>
    <tr class="tasks__item task">
        <td class="task__select">
            <label class="checkbox task__checkbox">
                <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                <span class="checkbox__text">Сделать главную страницу Дела в порядке</span>
            </label>
        </td>

        <td class="task__file">
            <a class="download-link" href="#">Home.psd</a>
        </td>

        <td class="task__date"></td>
    </tr>
    <!--показывать следующий тег <tr/>, если переменная $showCompleteTasks равна единице-->
</table>
