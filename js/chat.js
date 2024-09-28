var chat = {};

chat.fetchMessages = function(){
	$.ajax({
		url: 'ajax/Chat.php',
		type: 'post',
		data: { method: 'fetch' },
		success: function(data){
			$('.chat .messages').html(data);
		}
	});
}

chat.entry = $('.chat .entry');
chat.entry.bind('keydown', function(e){	
	var formValid = document.getElementById("soumission");	

	formValid.addEventListener('click', validation);
	
	function validation(){
		chat.throwMessage(document.formChat.message.value);
		e.preventDefault();
		
	}	
});

chat.interval = setInterval(chat.fetchMessages, 2000);
chat.fetchMessages();