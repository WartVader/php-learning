<?php
?>
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post" autocomplete="off">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if($show_complete_tasks == true): ?> checked <?php endif;?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php if($show_complete_tasks == true): ?>
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
        <?php if($show_complete_tasks || !$task["is_complete"]): ?>
            <tr class="tasks__item task <?php if($task["is_complete"] == true): ?> task--completed <?php endif;?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox" <?php if($task["is_complete"] == true): ?> checked <?php endif;?>>
                        <span class="checkbox__text"><?= htmlspecialchars($task["name"]); ?></span>
                    </label>
                </td>
                <td class="task__date"><?= htmlspecialchars($task["date"]); ?></td>
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
    <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
</table>
