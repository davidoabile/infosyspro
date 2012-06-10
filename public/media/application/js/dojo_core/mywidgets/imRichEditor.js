/**
 * /*
 * 	 imRichEditor - A Dojo Widget that integrates TinyMCE
 * 	 @author Les Green
 *   orignal: http://disgruntleddevs.wordpress.com/2009/02/10/tinymce-and-dojo/
 * 	 Copyright (C) 2009 Intriguing Minds, Inc.
 *   
 *   Version 0.6
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *   Demo and Documentation can be found at:   
 *   http://www.grasshopperpebbles.com
 *
 */
dojo.provide("im.imRichEditor");

dojo.require("dijit._Widget");
//dojo.require("dijit._Templated");

//dojo.require("dijit.form.Button");
//dojo.require("dijit.form.TextBox");

dojo.declare("im.imRichEditor", [ dijit._Widget ], {
	//templatePath :dojo.moduleUrl("my", "widgets/layout/RichEditor.htm"),
	//templateString : "<textarea id='tAreas' name='tAreas' rows='80' cols='80'></textarea>",
	widgetsInTemplate: true,
	editor: null,
	skin: "o2k7",
	skin_variant: "silver",
	theme: "advanced",
	plugins: "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
	advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
	toolbar_location: "default",
	toolbar_align : "left",
	statusbar_location : "bottom",
	resizing: true,
	content_css: "",
	template_list_url : "",
	link_list_url : "",
	image_list_url : "",
	media_list_url : "",
	value: "",
	editorNode: "",
	initialized: false,
	
	postCreate : function() {
		this.inherited(arguments);
		if ((this.theme == "simple") && (this.toolbar_location == "default")) {
			var ed = new tinymce.Editor(this.editorNode, {
				theme: this.theme,
				skin : this.skin,
				skin_variant: this.skin_variant
			});
		} else if ((this.theme == "simple") && (this.toolbar_location == "top")) {
			var ed = new tinymce.Editor(this.editorNode, {
				theme: "advanced",
				skin : this.skin,
				skin_variant: this.skin_variant,
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,undo,redo,|cleanup,|,bullist,numlist",
				theme_advanced_buttons2: "",
				theme_advanced_toolbar_align : this.toolbar_align,
				theme_advanced_toolbar_location : this.toolbar_location
			});
		} else {
			var tool_loc = (this.toolbar_location == "default") ? "top" : this.toolbar_location;
			var ed = new tinymce.Editor(this.editorNode, {
				theme: this.theme,
				skin : this.skin,
				skin_variant: this.skin_variant,
				plugins : this.plugins,
	
				theme_advanced_buttons1 : this.advanced_buttons1,
				theme_advanced_buttons2 : this.advanced_buttons2,
				theme_advanced_buttons3 : this.advanced_buttons3,
				theme_advanced_buttons4 : this.advanced_buttons4,
				theme_advanced_toolbar_location : tool_loc,
				theme_advanced_toolbar_align : this.toolbar_align,
				theme_advanced_statusbar_location : this.statusbar_location,
				theme_advanced_resizing : this.resizing,
				
				content_css : this.content_css,
				
				// Drop lists for link/image/media/template dialogs
				template_external_list_url : this.template_list_url,
				external_link_list_url : this.link_list_url,
				external_image_list_url : this.image_list_url,
				media_external_list_url : this.media_list_url
			});
		}
		
		setTimeout(function() { ed.render(); }, 50);
		
		this.editor = ed;
		this.editor.onInit.add(dojo.hitch(this, function() {
			this.initialized = true;
			this.setValue(this.value);
		}));
	},
	
	setValue: function(value) {
		if (this.initialized) {
			this.editor.setContent(value);
		} else {
			this.value = value;
		}
	},
	
	getValue: function() {
		if (this.initialized) {
			return this.editor.getContent();
		} else {
			return this.value;
		}
	},
	
	destroy: function() {
		this.inherited(arguments);
		this.editor.destroy();
		tinyMCE.remove(this.editor);
	}
});