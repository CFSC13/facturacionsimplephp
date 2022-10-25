/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

 CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'es';
	config.filebrowserUploadMethod  = "form";
	// config.uiColor = '#AADC6E';
};

CKEDITOR.plugins.add('etiquetas',
{
	requires : ['richcombo'],
	init : function( editor )
	{
	//  array of strings to choose from that'll be inserted into the editor
	var strings = [];
	strings.push(['{numero_expediente}', 'Nro. de Expediente', 'Nro. de Expediente']);
	strings.push(['{iniciador}', 'Iniciador', 'Iniciador']);
	strings.push(['{fecha_inicio_expediente}', 'Fecha', 'Fecha']);
	strings.push(['{caratula}', 'Caratula', 'Caratula']);
	strings.push(['{oficio}', 'Oficio', 'Oficio']);
	// add the menu to the editor
	editor.ui.addRichCombo('etiquetas',
	{
		label: 		'Expediente',
		title: 		'Agregar Etiquetas',
		voiceLabel: 'Agregar Etiquetas',
		className: 	'cke_format',
		multiSelect:false,
		panel:
		{
			css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
			voiceLabel: editor.lang.panelVoiceLabel
		},

		init: function()
		{
			this.startGroup( "Etiquetas" );
			for (var i in strings)
			{
				this.add(strings[i][0], strings[i][1], strings[i][2]);
			}
		},

		onClick: function( value )
		{
			editor.focus();
			editor.fire( 'poner_etiqueta' );
			editor.insertHtml(value);
			editor.fire( 'poner_etiqueta' );
		}
	});
}
});

CKEDITOR.plugins.add('etiquetas_ti',
{
	requires1 : ['richcombo'],
	init : function( editor )
	{
	//  array of strings to choose from that'll be inserted into the editor
	var strings = [];
	strings.push(['{numero_ti}', 'Nro. de TI', 'Nro. de TI']);
	strings.push(['{iniciador_ti}', 'Iniciador', 'Iniciador']);
	strings.push(['{fecha_inicio_ti}', 'Fecha', 'Fecha']);
	strings.push(['{caratula_ti}', 'Caratula', 'Caratula']);
	strings.push(['{titulo_ti}', 'Titulo', 'Titulo']);
	// add the menu to the editor
	editor.ui.addRichCombo('etiquetas_ti',
	{
		label: 		'Trátes Int.',
		title: 		'Agregar Etiquetas',
		voiceLabel: 'Agregar Etiquetas',
		className: 	'cke_format',
		multiSelect:false,
		panel:
		{
			css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
			voiceLabel: editor.lang.panelVoiceLabel
		},

		init: function()
		{
			this.startGroup( "Etiquetas" );
			for (var i in strings)
			{
				this.add(strings[i][0], strings[i][1], strings[i][2]);
			}
		},

		onClick: function( value )
		{
			editor.focus();
			editor.fire( 'poner_etiqueta' );
			editor.insertHtml(value);
			editor.fire( 'poner_etiqueta' );
		}
	});
}
});


CKEDITOR.plugins.add('etiquetas_proveedores',
{
	requires1 : ['richcombo'],
	init : function( editor )
	{
	//  array of strings to choose from that'll be inserted into the editor
	var strings = [];
	strings.push(['{razon_social}', 'Razon Social', 'Razon Social']);
	strings.push(['{cuit}', 'Cuit', 'Cuit']);
	strings.push(['{domicilio_proveedor}', 'Domicilio', 'Domicilio']);
	strings.push(['{clave_unica}', 'Clave Unica', 'Clave Unica']);
	strings.push(['{numero_inscripcion}', 'Numero Inscripcion', 'Numero Inscripcion']);
	// add the menu to the editor
	editor.ui.addRichCombo('etiquetas_proveedores',
	{
		label: 		'Proveedor',
		title: 		'Agregar Etiquetas',
		voiceLabel: 'Agregar Etiquetas',
		className: 	'cke_format',
		multiSelect:false,
		panel:
		{
			css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
			voiceLabel: editor.lang.panelVoiceLabel
		},

		init: function()
		{
			this.startGroup( "Etiquetas" );
			for (var i in strings)
			{
				this.add(strings[i][0], strings[i][1], strings[i][2]);
			}
		},

		onClick: function( value )
		{
			editor.focus();
			editor.fire( 'poner_etiqueta' );
			editor.insertHtml(value);
			editor.fire( 'poner_etiqueta' );
		}
	});
}
});

CKEDITOR.plugins.add('etiquetas_fechas',
{
	requires1 : ['richcombo'],
	init : function( editor )
	{
	//  array of strings to choose from that'll be inserted into the editor
	var strings = [];
	strings.push(['{fecha_corta}', 'Fecha Corta', 'dd/mm/aaaa']);
	strings.push(['{fecha_larga}', 'Fecha Larga', 'xx de xxxxxxxx de xxxx']);
	// add the menu to the editor
	editor.ui.addRichCombo('etiquetas_fechas',
	{
		label: 		'Fechas',
		title: 		'Agregar Etiquetas',
		voiceLabel: 'Agregar Etiquetas',
		className: 	'cke_format',
		multiSelect:false,
		panel:
		{
			css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
			voiceLabel: editor.lang.panelVoiceLabel
		},

		init: function()
		{
			this.startGroup( "Etiquetas" );
			for (var i in strings)
			{
				this.add(strings[i][0], strings[i][1], strings[i][2]);
			}
		},

		onClick: function( value )
		{
			editor.focus();
			editor.fire( 'poner_etiqueta' );
			editor.insertHtml(value);
			editor.fire( 'poner_etiqueta' );
		}
	});
}
});


CKEDITOR.plugins.add('etiquetas_compras',
{
	requires1 : ['richcombo'],
	init : function( editor )
	{
	//  array of strings to choose from that'll be inserted into the editor
	var strings = [];
	strings.push(['{plazo_presupuesto}', 'Plazo Presupuesto', 'Plazo de entrega del Presupuesto']);
	strings.push(['{lugar_entrega}', 'Lugar de Entrega', 'Lugar de Entrega']);
	strings.push(['{numero_tipo_compra}', 'Numero Tipo de Compra', 'Numero Tipo de Compra']);
	strings.push(['{tabla_renglones}', 'Tabla de Renglones', 'Tabla de Renglones']);
	strings.push(['{tabla_renglones_licitaciones}', 'Tabla de Renglones Licitación', 'Tabla de Renglones Licitación']);
	strings.push(['{fecha_apertura}', 'Fecha de Apertura', 'Fecha de Apertura']);
	strings.push(['{hora_apertura}', 'Hora de Apertura', 'Hora de Apertura']);
	strings.push(['{fecha_plazo_maximo}', 'Fecha Plazo Máximo', 'Fecha Plazo Máximo']);
	strings.push(['{hora_plazo_maximo}', 'Hora Plazo Máximo', 'Hora Plazo Máximo']);
	strings.push(['{plazo_entrega}', 'Plazo de Entrega', 'Plazo de Entrega']);
	strings.push(['{fecha_visita}', 'Fecha Visita de Obra', 'Fecha Visita de Obra']);
	strings.push(['{hora_visita}', 'Hora Visita de Obra', 'Hora Visita de Obra']);
	strings.push(['{instrumento_legal}', 'Instrumento Legal', 'Instrumento Legal']);
	strings.push(['{observacion_presupuesto}', 'Observ. Presupuesto', 'Observ. Presupuesto']);

	// add the menu to the editor
	editor.ui.addRichCombo('etiquetas_compras',
	{
		label: 		'Compras',
		title: 		'Agregar Etiquetas',
		voiceLabel: 'Agregar Etiquetas',
		className: 	'cke_format',
		multiSelect:false,
		panel:
		{
			css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
			voiceLabel: editor.lang.panelVoiceLabel
		},

		init: function()
		{
			this.startGroup( "Etiquetas" );
			for (var i in strings)
			{
				this.add(strings[i][0], strings[i][1], strings[i][2]);
			}
		},

		onClick: function( value )
		{
			editor.focus();
			editor.fire( 'poner_etiqueta' );
			editor.insertHtml(value);
			editor.fire( 'poner_etiqueta' );
		}
	});
}
});

CKEDITOR.plugins.add('etiquetas_proveedores_compras',
{
	requires1 : ['richcombo'],
	init : function( editor )
	{
	//  array of strings to choose from that'll be inserted into the editor
	var strings = [];
	strings.push(['{razon_social_compras}', 'Razon Social', 'Razon Social']);
	strings.push(['{cuit_compras}', 'Cuit', 'Cuit']);
	strings.push(['{domicilio_proveedor_compras}', 'Domicilio', 'Domicilio']);	
	strings.push(['{localidad_proveedor_compras}', 'Localidad', 'Localidad']);

	// add the menu to the editor
	editor.ui.addRichCombo('etiquetas_proveedores_compras',
	{
		label: 		'Proveedor',
		title: 		'Agregar Etiquetas',
		voiceLabel: 'Agregar Etiquetas',
		className: 	'cke_format',
		multiSelect:false,
		panel:
		{
			css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
			voiceLabel: editor.lang.panelVoiceLabel
		},

		init: function()
		{
			this.startGroup( "Etiquetas" );
			for (var i in strings)
			{
				this.add(strings[i][0], strings[i][1], strings[i][2]);
			}
		},

		onClick: function( value )
		{
			editor.focus();
			editor.fire( 'poner_etiqueta' );
			editor.insertHtml(value);
			editor.fire( 'poner_etiqueta' );
		}
	});
}
});


CKEDITOR.plugins.add('etiquetas_contrato_obras',
{
	requires1 : ['richcombo'],
	init : function( editor )
	{
	//  array of strings to choose from that'll be inserted into the editor
	var strings = [];
	strings.push(['{numero_contrato_obra}', 'Número Contrato', 'Número Contrato']);
	strings.push(['{monto_adjudicado_letras}', 'Monto Letras', 'Monto Adjudicado Letras']);
	strings.push(['{monto_adjudicado_numeros}', 'Monto Número', 'Monto Adjudicado Número']);
	strings.push(['{numero_resolucion_contrato}', 'Número de Resolución', 'Número de Resolución']);
	strings.push(['{fecha_resolucion_contrato}', 'Fecha de Resolución', 'Fecha de Resolución']);

	// add the menu to the editor
	editor.ui.addRichCombo('etiquetas_contrato_obras',
	{
		label: 		'Contrato de Obras',
		title: 		'Agregar Etiquetas',
		voiceLabel: 'Agregar Etiquetas',
		className: 	'cke_format',
		multiSelect:false,
		panel:
		{
			css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
			voiceLabel: editor.lang.panelVoiceLabel
		},

		init: function()
		{
			this.startGroup( "Etiquetas" );
			for (var i in strings)
			{
				this.add(strings[i][0], strings[i][1], strings[i][2]);
			}
		},

		onClick: function( value )
		{
			editor.focus();
			editor.fire( 'poner_etiqueta' );
			editor.insertHtml(value);
			editor.fire( 'poner_etiqueta' );
		}
	});
}
});
