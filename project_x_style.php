<style>

  #tab_team {
    width: 280px;
    border-style: none ;
    margin-left: auto; 
    margin-right: auto;
  }

  input.del_button {
    height: 40px;
    width: 80px;
    display:inline-block;
    border-radius:0.3em;
    box-sizing: border-box;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    color:#FFFFFF;
    font-size: 14px;
    text-align: center;
    background-color:green;
    box-shadow: 1px 1px 50px 2px #80ff00 inset;
    box-shadow:1px 1px 10px 1px white;
    position:relative;
  }
  
  input.del_button:active {
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px white;
    scale: 0.95;
    top: -3px;

    background-color: #80ff40;
  }

  input.del_button:hover {
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px white;
    scale: 1.05 1.03;
    position:relative;
    text-align: center;
    background-color: #004600;
  }

  input.team_button {
    height: 22px;
    width: 280px;
    display:inline-block;
    border-radius:0.3em;
    box-sizing: border-box;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    color:#FFFFFF;
    font-size: 14px;
    text-align: center;
    background-color:green;
    box-shadow: 1px 1px 50px 2px #80ff00 inset;
    box-shadow:1px 1px 10px 1px white;
    position:relative;
  }
  
  input.team_button:active {
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px white;
    scale: 0.95;
    top: -3px;

    background-color: #80ff40;
  }

  input.team_button:hover {
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px white;
    scale: 1.05 1.03;
    position:relative;
    text-align: center;
    background-color: #004600;
  }

.button_team_cell {
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 27px;
    width: 280px;
    color: black;
    padding-right: 5px;
    padding-left: 5px;
  }

  .team_name_cell {
    background-image: url("/portal/project_x_images/team.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  .club_name_cell {
    background-image: url("/portal/project_x_images/club.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  .coach_cell {
    background-image: url("/portal/project_x_images/trainer.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  .coach_license_cell {
    background-image: url("/portal/project_x_images/licence_num.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  .second_coach_name_cell {
    background-image: url("/portal/project_x_images/second_trainer.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  .masseur_name_cell {
    background-image: url("/portal/project_x_images/masseur.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  .doctor_name_cell {
    background-image: url("/portal/project_x_images/doctor.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  .manager_name_cell {
    background-image: url("/portal/project_x_images/menager.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  .director_name_cell {
    background-image: url("/portal/project_x_images/director.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position: center;
    border-style: none ;
    table-layout: fixed;
    height: 40px;
    width: 280px;
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-right: 10px;
    padding-left: 10px;
    border-color: green;
  }

  p.title_player {
    text-align: center;
    color: red;
    font-size: 24px;
  }

  #tab_player {
    width: 100%;
    border-style: none ;
  }

  #tab_player td {
    border-style: none ;
  }

  #tab_player p {
    text-align: center;
    color: red;
    font-size: 24px;
  }

  table.single_tab_base_payer {
    border: 5px solid transparent;
    width: 280px;
    height: 90px;
    text-align: center;
    color: black;
    display: inline-block;
    vertical-align: top;
    table-layout: fixed;
  }

  .tshirt_cell {
    background-image: url("/portal/project_x_images/tshirt.png");
    background-repeat: no-repeat;
    border-style: none ;
    background-size: 100%;
    height: 40px;
    width: 40px;
    border-color: green;
    table-layout: fixed;
    padding: 5px;
  }

  .name_surname_cell {
    background-image: url("/portal/project_x_images/name_surname.png");
    background-color: #64ff64;
    background-repeat: no-repeat;
    background-position:right 1px;
    border-style: none ;
    background-size: 100%;
    table-layout: fixed;
    height: 40px;
    width: 240px;
    border-color: green;
  }

  .name_text {
    font-size: 13px;
    margin-top: 4px;
    line-height: 11px;
  }

  .tshirt_text {
    
  }
  .dob_cell {
    background-image: url("/portal/project_x_images/dob.png");
    background-repeat: no-repeat;
    background-color: #64ff64;
    background-position: center;
    border-style: none ;
    background-size: 100%;
    table-layout: fixed;
    height: 40px;
    font-size: 12px;
    width: 80px;
    border-color: green;
  }

  .edit_cell {
    background-color: #64ff64;
    border-style: none ;
    height: 40px;
    table-layout: fixed;
    width: 80px;
    border-color: green;
  }

  .move_to_cell {
    background-color: #64ff64;
    border-style: none ;
    height: 40px;
    table-layout: fixed;
    width: 120px;
    border-color: green;
  }
  
  input.button_edit {
    height: 19px;
    width: 70px;
    left: 0px;
    top: -4px;
    display:inline-block;
    border-radius:0.2em;
    box-sizing: border-box;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    color:#FFFFFF;
    font-size: 10px;
    text-align: center;
    background-color:	#0086b3;
    box-shadow: 2px 2px 25px 10px #00394d inset;
    box-shadow:2px 2px 10px 1px black;
    position:relative;
  }
  
  input.button_edit:active {
    box-shadow: 2px 2px 50px 2px #4dcfff inset;
    box-shadow:2px 2px 10px 1px black;
    scale: 0.95;
    top: -3px;
    background-color: #00394d;
  }

  input.button_edit:hover {
    box-shadow: 2px 2px 50px 2px #4dcfff inset;
    box-shadow:2px 2px 10px 1px black;
    scale: 1.05 1.03;
    position:relative;
    text-align: center;
    background-color: #00394d;
}

  input.button_delete {
    height: 19px;
    width: 70px;
    left: 0px;
    top: -4px;
    display:inline-block;
    border-radius:0.2em;
    box-sizing: border-box;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    color:#FFFFFF;
    font-size: 10px;
    text-align: center;
    background-color:	#e60000;
    box-shadow: 2px 2px 25px 10px #800000 inset;
    box-shadow:2px 2px 10px 1px black;
    position:relative;
  }
  
  input.button_delete:active {
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px black;
    scale: 0.95;
    top: -3px;
    background-color: #900000;
  }

  input.button_delete:hover {
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px black;
    scale: 1.05 1.03;
    position:relative;
    text-align: center;
    background-color: #600000;
}

  input.button_move_to {
    height: 19px;
    width: 100px;
    left: -2px;
    top: -4px;
    display:inline-block;
    border-radius:0.2em;
    box-sizing: border-box;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    color:#FFFFFF;
    font-size: 10px;
    text-align: center;
    background-color:green;
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px black;
    position:relative;
    /* transition: all 0.5s ease 0s;
    transform: all; */
  }
  
  input.button_move_to:active {
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px black;
    scale: 0.95;
    top: -3px;
    /* transition: all 1.0s ease 0s;
    transform: all; */
    background-color: #80ff40;
  }

  input.button_move_to:hover {
    box-shadow: 2px 2px 50px 2px #80ff00 inset;
    box-shadow:2px 2px 10px 1px black;
    scale: 1.05 1.03;
    /* transition: all 1.0s ease 0s;
    transform: all; */
    position:relative;
    text-align: center;
    background-color: #004600;
}

input.button_move_to_off {
    height: 19px;
    width: 100px;
    left: -2px;
    top: -4px;
    display:inline-block;
    border-radius:0.2em;
    box-sizing: border-box;
    text-decoration:none;
    font-family:'Roboto',sans-serif;
    color:#aaaaaa;
    font-size: 10px;
    text-align: center;
    background-color:#454545;
    box-shadow: 2px 2px 50px 2px #252525 inset;
    box-shadow:2px 2px 10px 1px black;
    position:relative;
    /* transition: all 0.5s ease 0s;
    transform: all; */
    pointer-events: none;
  }


</style>