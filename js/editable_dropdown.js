
  function fnLeftToRight(getdropdown)
  {
    getdropdown.style.direction = "ltr";
  }

  function fnRightToLeft(getdropdown)
  {
    getdropdown.style.direction = "rtl";
  }

  function FindKeyCode(e)
  {
    if(e.which)
    {
    keycode=e.which;  //NetscapeFirefoxChrome
    }
    else
    {
    keycode=e.keyCode; //Internet Explorer
    }

    //alert("FindKeyCode"+ keycode);
    return keycode;
  }

  function FindKeyChar(e)
  {
    keycode = FindKeyCode(e);
    if((keycode==8)||(keycode==127))
    {
    character="backspace"
    }
    else if((keycode==46))
    {
    character="delete"
    }
    else
    {
    character=String.fromCharCode(keycode);
    }
    //alert("FindKey"+ character);
    return character;
  }



  var vEditableOptionIndex_A = 0;


  var vEditableOptionText_A = "--?--";

 var vUseActualTexbox_A = "no";

  var vPreviousSelectIndex_A = 0;
  // Contains the Previously Selected Index, set to 0 by default

  var vSelectIndex_A = 0;
  // Contains the Currently Selected Index, set to 0 by default

  var vSelectChange_A = 'MANUAL_CLICK';
 
  function fnSanityCheck_A(getdropdown)
  {
    if(vEditableOptionIndex_A>(getdropdown.options.length-1))
    {
    alert("PROGRAMMING ERROR: The value of variable vEditableOptionIndex_... cannot be greater than (length of dropdown - 1)");
    return false;
    }
  }

  function fnKeyDownHandler_A(getdropdown, e)
  {
    fnSanityCheck_A(getdropdown);

  var vEventKeyCode = FindKeyCode(e);

    // Press left/right arrow keys
    if(vEventKeyCode == 37)
    {
      fnLeftToRight(getdropdown);
    }
    if(vEventKeyCode == 39)
    {
      fnRightToLeft(getdropdown);
    }

    // Delete key pressed
    if(vEventKeyCode == 46)
    {
      if(getdropdown.options.length != 0)
      // if dropdown is not empty
      {
        if (getdropdown.options.selectedIndex == vEditableOptionIndex_A)
        // if option is the Editable field
        {
          getdropdown.options[getdropdown.options.selectedIndex].text = '';
          getdropdown.options[getdropdown.options.selectedIndex].value = '';
        }
      }
    }

    // backspace key pressed
    if(vEventKeyCode == 8 || vEventKeyCode == 127)
    {
      if(getdropdown.options.length != 0)
      // if dropdown is not empty
      {
        if (getdropdown.options.selectedIndex == vEditableOptionIndex_A)
        // if option is the Editable field
        {
           // make Editable option Null if it is being edited for the first time
           if ((getdropdown[vEditableOptionIndex_A].text == vEditableOptionText_A)||(getdropdown[vEditableOptionIndex_A].value == vEditableOptionText_A))
           {
             getdropdown.options[getdropdown.options.selectedIndex].text = '';
             getdropdown.options[getdropdown.options.selectedIndex].value = '';
           }
           else
           {
             getdropdown.options[getdropdown.options.selectedIndex].text = getdropdown.options[getdropdown.options.selectedIndex].text.slice(0,-1);
             getdropdown.options[getdropdown.options.selectedIndex].value = getdropdown.options[getdropdown.options.selectedIndex].value.slice(0,-1);
           }
        }
      }
      if(e.which) //NetscapeFirefoxChrome
      {
        e.which = '';
      }
      else //Internet Explorer
      {
        e.keyCode = '';
      }
      if (e.cancelBubble)	  //Internet Explorer
      {
        e.cancelBubble = true;
        e.returnValue = false;
      }
      if (e.stopPropagation)	 //NetscapeFirefoxChrome
      {
          e.stopPropagation();
      }
      if (e.preventDefault)	 //NetscapeFirefoxChrome
      {
      	e.preventDefault();
      }
    }
  }

  function fnFocusHandler_A(getdropdown)
  {
    //use textbox for devices such as android and ipad that don't have a physical keyboard (textbox allows use of virtual soft keyboard)
    if ( (navigator.userAgent.toLowerCase().search(/android|ipad|iphone|ipod/) > -1) || (vUseActualTexbox_A == 'yes') )
    {
      if (getdropdown[(vEditableOptionIndex_A)].selected == true)
      {
        document.getElementById('textboxoption_A').style.visibility='';
        document.getElementById('textboxoption_A').style.display='';
      }
      else
      {
        document.getElementById('textboxoption_A').style.visibility='hidden';
        document.getElementById('textboxoption_A').style.display='none';
      }
    }
  }

  function fnChangeHandler_A(getdropdown)
  {
    fnSanityCheck_A(getdropdown);

    vPreviousSelectIndex_A = vSelectIndex_A;
    // Contains the Previously Selected Index

    vSelectIndex_A = getdropdown.options.selectedIndex;
    // Contains the Currently Selected Index

    if ((vPreviousSelectIndex_A == (vEditableOptionIndex_A)) && (vSelectIndex_A != (vEditableOptionIndex_A))&&(vSelectChange_A != 'MANUAL_CLICK'))
    // To Set value of Index variables - source: http://chakrabarty.com/pp_editable_dropdown.html
    {
      getdropdown[(vEditableOptionIndex_A)].selected=true;
      vPreviousSelectIndex_A = vSelectIndex_A;
      vSelectIndex_A = getdropdown.options.selectedIndex;
      vSelectChange_A = 'MANUAL_CLICK';
      // Indicates that the Change in dropdown selected
      // option was due to a Manual Click
    }

    //use textbox for devices such as android and ipad that don't have a physical keyboard (textbox allows use of virtual soft keyboard)
    if ( (navigator.userAgent.toLowerCase().search(/android|ipad|iphone|ipod/) > -1) || (vUseActualTexbox_A == 'yes') )
    {
      fnFocusHandler_A(getdropdown);
    }
  }

  function fnKeyPressHandler_A(getdropdown, e)
  {
    fnSanityCheck_A(getdropdown);

    keycode = FindKeyCode(e);
    keychar = FindKeyChar(e);

    if ((keycode>47 && keycode<59)||(keycode>62 && keycode<127) ||(keycode==32))
    {
      var vAllowableCharacter = "yes";
    }
    else
    {
      var vAllowableCharacter = "no";
    }

    //alert(window); alert(window.event);

    if(getdropdown.options.length != 0)
    // if dropdown is not empty
      if (getdropdown.options.selectedIndex == (vEditableOptionIndex_A))
      // if selected option the Editable option of the dropdown
      {

      var vEditString = getdropdown[vEditableOptionIndex_A].value;

        // make Editable option Null if it is being edited for the first time
        if(vAllowableCharacter == "yes")
        {
          if ((getdropdown[vEditableOptionIndex_A].text == vEditableOptionText_A)||(getdropdown[vEditableOptionIndex_A].value == vEditableOptionText_A))
            vEditString = "";
        }

        if (vAllowableCharacter == "yes")
        // To handle addition of a character - source: http://chakrabarty.com/pp_editable_dropdown.html
        {
          vEditString+=String.fromCharCode(keycode);
       
          var i=0;
          var vEnteredChar = String.fromCharCode(keycode);
          var vUpperCaseEnteredChar = vEnteredChar;
          var vLowerCaseEnteredChar = vEnteredChar;


          if(((keycode)>=97)&&((keycode)<=122))
          // if vEnteredChar lowercase
            vUpperCaseEnteredChar = String.fromCharCode(keycode - 32);
            // This is UpperCase


          if(((keycode)>=65)&&((keycode)<=90))
          // if vEnteredChar is UpperCase
            vLowerCaseEnteredChar = String.fromCharCode(keycode + 32);
            // This is lowercase

          if(e.which) //For NetscapeFirefoxChrome
          {
            
            for (i=0;i<=(getdropdown.options.length-1);i++)
            {
              if(i!=vEditableOptionIndex_A)
              {
                var vEnteredDigitNumber = getdropdown[vEditableOptionIndex_A].text.length;
                var vFirstReadOnlyChar = getdropdown[i].text.substring(0,1);
                var vEquivalentReadOnlyChar = getdropdown[i].text.substring(vEnteredDigitNumber,vEnteredDigitNumber+1);
                if (vEnteredDigitNumber >= getdropdown[i].text.length)
                {
                    vEquivalentReadOnlyChar = vFirstReadOnlyChar;
                }
                if( (vEquivalentReadOnlyChar == vUpperCaseEnteredChar)||(vEquivalentReadOnlyChar == vLowerCaseEnteredChar)
                  ||(vFirstReadOnlyChar == vUpperCaseEnteredChar)||(vFirstReadOnlyChar == vLowerCaseEnteredChar) )
                {
                  vSelectChange_A = 'AUTO_SYSTEM';
                  // Indicates that the Change in dropdown selected
                  // option was due to System properties of dropdown
                  break;
                }
                else
                {
                  vSelectChange_A = 'MANUAL_CLICK';
                  // Indicates that the Change in dropdown selected
                  // option was due to a Manual Click
                }
              }
            }
          }
        }

        // Set the new edited string into the Editable option
        getdropdown.options[vEditableOptionIndex_A].text = vEditString;
        getdropdown.options[vEditableOptionIndex_A].value = vEditString;

        return false;
      }
    return true;
  }

  function fnKeyUpHandler_A(getdropdown, e)
  {
    fnSanityCheck_A(getdropdown);

    if(e.which) // NetscapeFirefoxChrome
    {
      if(vSelectChange_A == 'AUTO_SYSTEM')
      {
        // if editable dropdown option jumped while editing
        // (due to typing of a character which is the first character of some other option)
        // then go back to the editable option.
        getdropdown[(vEditableOptionIndex_A)].selected=true;
        vSelectChange_A = 'MANUAL_CLICK';
      }

      var vEventKeyCode = FindKeyCode(e);
      // if [ <- ] or [ -> ] arrow keys are pressed, select the editable option
      if((vEventKeyCode == 37)||(vEventKeyCode == 39))
      {
        getdropdown[vEditableOptionIndex_A].selected=true;
      }
    }
  }

