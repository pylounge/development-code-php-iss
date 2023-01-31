<h2>Авторизация</h2>
			<div class="error" id="error"><?=$info;?></div>
                <form method="post" id="form">
				<div class="reg-wrapper">
					<div class="string">
						<label for="">Логин:</label>
						<input  data-desc="Логин" type="text" name="login" required>
					</div>
					<div class="string">
						<label for="">Пароль:</label>
						<input  data-desc="Пароль" id="pass" type="password" name="password" required>
					</div>
					<div class="string buttons">
						<button name="enter-btn" id="enter-btn">Войти</button>
                        <button id="reg-btn" name="reg-btn" onclick="document.location='/app/registration'">Регистрация</button> 
					</div>
				</div>
				</form>
