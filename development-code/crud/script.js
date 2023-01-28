 document.addEventListener("DOMContentLoaded", () => { 
	loadUsers(); 
});

async function loadUsers(){
	let response =  await fetch('read.php');
	let json = null;
	if (response.ok) { 
		json =  await response.json();
	} else {
		alert("Ошибка HTTP: " + response.status);
	}
			
	let text_users = "";
	for(let i = 0; i < json.length; i++) {
		let obj = json[i];
		text_users += ` <div class="item">
						<p>${obj.id}</p>
						<p>${obj.login}</p>
						<p>${obj.email}</p>
						<div>
							<button data-userid="${obj.id}" onclick="editUser(event)">Edit</button>
							<button data-userid="${obj.id}" onclick="delUser(event)">Х</button>
							</div>
						</div>`;
	}
	document.getElementById('result').innerHTML = text_users;
}

async function createUser(){
	var login = document.getElementById('login').value;
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
					
	var params = new URLSearchParams(); 
	params.set('login', login);
	params.set('email', email);
	params.set('password', password);

	let response =  await fetch('create.php', {
		method: 'POST',
		body: params
	});
					
	if (response.ok) { 
		loadUsers();
	} else {
		alert("Ошибка HTTP: " + response.status);
	}
}
	  
async function delUser(e){
	e.preventDefault();
	
	const id = e.target.getAttribute('data-userid');
	var params = new URLSearchParams(); 
	params.set('id', id);
	let response =  await fetch('delete.php', {
		method: 'POST',
		body: params
	});
				
	if (response.ok) { 
		loadUsers();
	} else {
		alert("Ошибка HTTP: " + response.status);
	}
}  
		  
async function editUser(e){
	// модальное окно
	// либо подставлять в форму значения юзера и при нажатии на кнопку сохранить, искать юзера по id и изменять его
	console.log(e.target);
}
