function renderMessage(targetId, type, text){
  let className = "alert alert-" + type;

  if(type === "success"){
    className = "alert alert-premium-success";
  } else if(type === "danger"){
    className = "alert alert-premium-danger";
  }

  document.getElementById(targetId).innerHTML = `<div class="${className}">${text}</div>`;
}