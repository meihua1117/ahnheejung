// Toggle Function
var seed_string = "RJCC8siBxYxHjMhPvElLxkBFlARNApSIZQgIdhlMnIlNwt0OlwhG1UFORYzF8IwaY4gK2kyGY0DIV8xGCpBEatiFt0iWR1gJ6VxF8oRLjAyElEyNc4AZicwEngiGJoyUtAUOy1SESoDW10QXOkQMzVlBoICLrUgMBsxFmUjaHojAAwQOIEyD5MhGWhxBnowVFgSK10CQA4HGk8iK28AD8IQBfQhT0cQXKIgLpERLi4TMpxSOBAQDlghHWsAB1EFGDICDoUQGRgyBFkjTm4wLSdQIIgjCCEDDFBSB48iFVEVHEsBJ3B1Ln0xCjsTLMYyNIE3S0wFHi8iGJkCNYFxByhhDvYDWehxPCIlNVcBXrEiV48SKvQxGhsBUvslXuMCPQllG1skGLhFBDASUekgKq4COqQHBR8iK2UCCyIxOfQSVLQgDNsTA24xFQYRJTxxDdcgDLMwDRIAHIUlWMAiEE4BFacFC5IzfbwhBSxAGPklGqAAIdtxBaZBBDMQGpAxFtMEHwoxFTowGb1QB6cSV3AgIMgyJZERMLsiB";
$('.toggle').click(function(){
  // Switches the Icon
  $(this).children('i').toggleClass('fa-pencil');
  // Switches the forms  
  $('.form').animate({
    height: "toggle",
    'padding-top': 'toggle',
    'padding-bottom': 'toggle',
    opacity: "toggle"
  }, "slow");
});