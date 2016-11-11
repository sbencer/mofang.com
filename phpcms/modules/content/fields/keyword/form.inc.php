	function keyword($field, $value, $fieldinfo) {
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return "<input type='text' name='info[$field]' id='$field' value='$value' style='width:280px' {$formattribute} {$css} class='input-text'>".
		'<script>
		$(function() {
		    function split( val ) {
		      return val.split( /,\s*/ );
		    }
		    function extractLast( term ) {
		      return split( term ).pop();
		    }
		    function count( term ){
		      return split( term ).length;
		    }
		 
		    $( "#'.$field.'" )
		      // don\'t navigate away from the field on tab when selecting an item
		      .bind( "keydown", function( event ) {
		        if ( event.keyCode === $.ui.keyCode.TAB &&
		            $( this ).data( "ui-autocomplete" ).menu.active ) {
		          event.preventDefault();
		        }
		      })
		      .autocomplete({
		        source: function( request, response ) {
		          $.getJSON( "?m=admin&c=keywords&a=get_keywords&pc_hash="+pc_hash, {
		            term: extractLast( request.term ),
		            count: count( request.term )
		          }, response );
		        },
		        search: function() {
		          // custom minLength
		          var term = extractLast( this.value );
		          if ( term.length < 1 ) {
		            return false;
		          }
		        },
		        focus: function() {
		          // prevent value inserted on focus
		          return false;
		        },
		        select: function( event, ui ) {
		          var terms = split( this.value );
		          // remove the current input
		          terms.pop();
		          // add the selected item
		          terms.push( ui.item.value );
		          // add placeholder to get the comma-and-space at the end
		          terms.push( "" );
		          this.value = terms.join( ", " );
		          return false;
		        }
		      });
		  });
	</script>
		';
	}
