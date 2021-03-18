
<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?php if(isset($errors['name'])): ?>form__input--error<?php endif;?>" type="text" name="name" id="name" value="<?php if(isset($values['name'])): ?><?= $values['name']; ?><?php endif;?>" placeholder="Введите название">
		<?php if(isset($errors['name'])): ?> <p class="form__message"> <?= $errors['name']; ?> </p> <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>

        <select class="form__input form__input--select <?php if(isset($errors['project'])): ?>form__input--error<?php endif;?>" name="project" id="project">
            <?php foreach($projects as $project): ?>
                <option <?php if(isset($values['project']) && $project['id'] == $values['project']): ?>selected<?php endif;?> value="<?= $project['id'] ?>"><?= htmlspecialchars($project['name']); ?></option>
            <?php endforeach;?>
        </select>
		<?php if(isset($errors['project'])): ?> <p class="form__message"> <?= $errors['project']; ?> </p> <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label <?php if(isset($errors['date'])): ?>form__input--error<?php endif;?>" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?php if(isset($errors['date'])): ?>form__input--error<?php endif;?>" type="text" name="date" id="date" value="<?php if(isset($values['date'])): ?><?= $values['date']; ?><?php endif;?>"
               placeholder="Введите дату в формате ГГГГ-ММ-ДД">
		<?php if(isset($errors['date'])): ?> <p class="form__message"> <?= $errors['date']; ?> </p> <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="file">Файл</label>

        <div class="form__input-file">
			<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
			<input class="visually-hidden" type="file" name="file" id="file" value="<?php if(isset($values['file'])): ?><?= $values['file']; ?><?php endif;?>">

            <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
            </label>
        </div>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>