/*!
* Start Bootstrap - Landing Page v6.0.6 (https://startbootstrap.com/theme/landing-page)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-landing-page/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project
function addblack(e)
{
    
    let buttonItem=e.outerHTML
    let item=(e.parentNode).parentNode
    e.outerHTML="<input type='button' value='解除' onclick= removeblack(this)>"
    let blackList=document.getElementById('addblack')
    let htmlItem=blackList.innerHTML
    blackList.innerHTML=htmlItem.replace(item.outerHTML," ")

    let blacktable=document.getElementById("removeblack")
    let tableText=blacktable.innerHTML
    console.log(tableText)
    tableText=tableText.replace("</tbody>","")
    tableText=tableText+item.outerHTML+"</tbody>"
    blacktable.innerHTML=tableText
    let account = item.querySelector('#addaccount').innerHTML
    console.log(typeof(account))
    $.ajax({
        type: 'POST',
        url:'updateblack.php',
        data:{accounts:account},
        success: alert('更新完成')
    });

}

function removeblack(e)
{
    let buttonItem=e.outerHTML
    let item=(e.parentNode).parentNode
    e.outerHTML="<input type='button' value='新增' onclick= addblack(this) style='width:40%; '>"
    let blackList=document.getElementById('removeblack')
    let htmlItem=blackList.innerHTML
    blackList.innerHTML=htmlItem.replace(item.outerHTML," ")

    let blacktable=document.getElementById("addblack")
    let tableText=blacktable.innerHTML
    console.log(tableText)
    tableText=tableText.replace("</tbody>","")
    tableText=tableText+item.outerHTML+"</tbody>"
    blacktable.innerHTML=tableText
    let account = item.querySelector('#removeaccount').innerHTML
    $.ajax({
        type: 'POST',
        url:'updateblack.php',
        data:{accounts:account},
        success: alert('更新完成')
    });
}