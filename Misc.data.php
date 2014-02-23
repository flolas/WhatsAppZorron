<?php
/**
 * Esto se recarga automaticamente, no es necesario reiniciar todo el sistema
 * Ojal‡ que esto no de problema de leak(lo m‡s probable es que si xD)
 * Misc Data
 * Ac‡ puedes agregar entradas b‡sicas sin comandos.
 * para llamar variables se usa siempre el mensaje en "", nunca en ''
 * y la variable dentro de corchetes {$this->variable}. ie "Hola {$this->name}!" output: Hola Felipe!
 * por defecto se envia una respuesta aleatoria de responses
 * @package WhatsApp
 *
 * @author Felipe Lolas <flolas@alumnos.uai.cl>
 */
return array(
	'saludar' =>Array('msgs'=>array(
							'hola',
							'wena',
							'oa',
			                'holi',
							'holanda'
					 ),
					  'responses'=>array(
					  		"Hola {$this->from}! :)",
					  		"Wena zorrron!",
					  		"Holanda que talca!",
					  		"Que paso maquina!"
					  		
					 )
					 )
		,
	'despedir'=>Array('msgs'=>array(
							'chao',
							'adios'
					 ),
					  'responses'=>array(
					  		"Adios {$this->from}! :)",
					  		"Adios zorrron!"
					 )
					 )
		,
	'estados_de_animo'=>Array('msgs'=>array(
							'como estay',
							'como tamos',
							'que talca',
							'como tay'
					 ),
					  'responses'=>array(
					  		"Bien y tu? :D",
					  		"Mal y tu?",
					  		"Con ca–a perrito y usted?",
					  		"Bien gracias :)",
					  		"Bien bien bien bien :)",
					 )
					 )
		,
	 'extras'=>Array('msgs'=>array(
					 		':)',
					 		':D'
					 ),
					  'responses'=>array(
					 		":)",
					 		":D"
					 )
					 )
		
);