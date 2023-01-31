<h2>Регистрация</h2>
<?=$info;?>
			<div class="error" id="error"></div>
                <form method="post" id="form">
				<div class="reg-wrapper">
					<div class="string">
						<label for="">Фамилия:</label>
						<input  data-desc="Фамилия" type="text" name="surname" required>
					</div>
					<div class="string">
						<label for="">Имя:</label>
						<input  data-desc="Имя" type="text" name="name" required>
					</div>
					<div class="string">
						<label for="">Отчество:</label>
						<input type="text" name="second_name">
					</div>
					<div class="string">
						<label for="">Дата рождения:</label>
						<input  data-desc="Дата рождения" type="date" name="birthdate" required>
					</div>
					<div class="string">
						<label for="">Пол:</label>
						<div>
							<input type="radio" name="sex" checked>Мужской</input>
							<input type="radio" name="sex">Женский</input>
						</div>	
					</div>
					<div class="string">
						<label for="">Вид деятельности:</label>
						<select size="1" name="activity">
							<option>Студент</option>
							<option>Работаю</option>
							<option>Безработный</option>
							<option>Пенсионер</option>
					</select>
					</div>
					<div class="string">
						<label for="">Логин:</label>
						<input  data-desc="Логин" type="text" name="login" required>
					</div>
					<div class="string">
						<label for="">Пароль:</label>
						<input  data-desc="Пароль" id="pass" type="password" name="password" required>
					</div>
					<div class="string">
						<label for="">Пароль ещё раз:</label>
						<input  data-desc="Пароль2" id="pass2" type="password" name="one_more_pass" required>
					</div>
					<div class="string">
						<label for="">Email:</label>
						<input  data-desc="Email" type="email" name="email"  placeholder="email@mail.ru" required>
					</div>
					<div class="string-agreement">
							<label for="">Соглашение:</label>
							<input  data-desc="Соглашение" id="agreement" type="checkbox" name="agreement" required>
					</div>
					<div class="string buttons">
						<input type="reset" value="Очистить">
						<button name="send" id="send" disabled>Отправить</button></p>
					</div>
				</div>
				</form>
