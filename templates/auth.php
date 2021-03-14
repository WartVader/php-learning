<h2 class="content__main-heading">Вход на сайт</h2>

<form class="form" action="auth.php" method="post" autocomplete="off">
	<div class="form__row">
		<label class="form__label" for="email">E-mail <sup>*</sup></label>

		<input class="form__input<?php if(isset($errors['email']) || isset($errors['all'])): ?> form__input--error<?php endif; ?>" type="text" name="email" id="email" value="<?php if(isset($values['email'])): ?><?= $values['email']; ?><?php endif; ?>"
			   placeholder="Введите e-mail">

		<?php if(isset($errors['email'])): ?> <p class="form__message"> <?= $errors['email']; ?> </p> <?php endif; ?>
	</div>

	<div class="form__row">
		<label class="form__label" for="password">Пароль <sup>*</sup></label>

		<input class="form__input<?php if(isset($errors['password']) || isset($errors['all'])): ?> form__input--error<?php endif; ?>" type="password" name="password" id="password" value="<?php if(isset($values['password'])): ?><?= $values['password']; ?><?php endif; ?>" placeholder="Введите пароль">

		<?php if(isset($errors['password'])): ?> <p class="form__message"> <?= $errors['password']; ?> </p> <?php endif; ?>
	</div>

	<div class="form__row form__row--controls">
		<?php if(isset($errors['all'])):?><p class="error-message"><?= $errors['all']; ?></p><?php endif;?>
		<input class="button" type="submit" name="" value="Войти">
	</div>
</form>