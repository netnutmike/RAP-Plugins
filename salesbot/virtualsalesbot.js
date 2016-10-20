/*************************************************************
 * Copyright Tyler Flemming
 * VirtualSalesBot.com
 *************************************************************/
// the time before the first message is posted
// also this is the time after user posts the message
// and before the "Agent is Typing" appears
var TimeInit = 1000;

// this is the time before agent begin typing the next
// post in automatic welcome mode.
var TimeBeforeNewPost = 1000;

// time which agent is "typing" the message
var TimeDelay = 5000;

// Name of agent used
var AgentName = 'Jennifer';

// array of welcome messages
var MessagesWelcome = new Array(
				"Hey wait! Don't go yet...",
				"I wanted to let you know about our other offers.",
				"We have a sale going on right now that I must share with you!",				
				"Go to our website and click on products.",
				"Then click on closeout items.",
				"Those are the products that we must get rid of.",
				"Hope that helps!"
				);

// array of messages used to answer users' posts
var MessagesDiscussion = new Array(
				"You can add as many custom replies here as you like.",
				"Whenever you type something, I will reply with something at random, which in practice, is really just the same as what the other much more expensive exit chat agents do.",
				"All my replies can include links and any other html you want to add.",
				"Most of the top marketers are using technology similar to this to greatly increase their conversions. They usually do this by offering a discount or other special offer right at the moment their visitors were about to leave their sites for good.",
				"Even a simple non intelligent, canned response like this increases your visitors interaction with your site, which increases the chance they will take action on your offers."
				);

var oDiscusson = document.getElementById("commentdiv");
var oUserMessages = document.getElementById("typediv");
var oAgentTyping = document.getElementById("divAgentIsTyping");
var tAgent = null;
var tPost = null;
var bConversationStarted = false;
var iPrevMessageId = -1;
var iCurrentWelcomeMessage = -1;

function GetRandomString(source)
{
	var iNewMessageId = Math.floor(Math.random()*source.length);
	if ((iPrevMessageId == iNewMessageId) && (source.length>1))
		return GetRandomString(source);
	iPrevMessageId = iNewMessageId;
	return source[iNewMessageId];
}

function onUserMessage()
{

	if (oUserMessages.value!='')
	{

		setAgentTypingOff();

		clearTimeout(tAgent);
		clearTimeout(tPost);

		tAgent = setTimeout ( "setAgentTypingOn()", TimeInit );
		tPost = setTimeout ( "postMessage('discussion')", TimeInit + TimeDelay);

		if (oDiscusson.innerHTML!='')
			oDiscusson.innerHTML = oDiscusson.innerHTML + '<br><br>';

		oDiscusson.innerHTML = oDiscusson.innerHTML + '<span class="messageUser"><b>You:</b> ' + oUserMessages.value + '</span>';
		oUserMessages.value = '';
		oDiscusson.scrollTop = oDiscusson.scrollHeight;
	}
}

function GetNextWelcomeMessage()
{
	if (iCurrentWelcomeMessage < MessagesWelcome.length-1)
	{
		iCurrentWelcomeMessage++;
		return MessagesWelcome[iCurrentWelcomeMessage];
	}
	return '';
}


function postMessage(sMessageType)
{

	if (sMessageType == 'discussion')
	{
		var sMessage = GetRandomString(MessagesDiscussion);
	}else{
		var sMessage = GetRandomString(MessagesWelcome);
		var sMessage = GetNextWelcomeMessage();
		if (!bConversationStarted && sMessage!='')
		{
			tAgent = setTimeout ( "setAgentTypingOn()", TimeBeforeNewPost);
			tPost = setTimeout ( "postMessage('" + sMessageType + "')", TimeBeforeNewPost + TimeDelay);
		}
	}

	if (sMessage!='')
	{
		if (oDiscusson.innerHTML!='')
			oDiscusson.innerHTML = oDiscusson.innerHTML + '<br><br>';
		oDiscusson.innerHTML = oDiscusson.innerHTML + '<span class="messageAgent"><b>' + AgentName + ':</b> ' + sMessage + '</span>';
	}

	setAgentTypingOff();

	oDiscusson.scrollTop = oDiscusson.scrollHeight;
}

function setAgentTypingOn()
{
	oAgentTyping.innerHTML = AgentName + ' Is Typing...';
}

function setAgentTypingOff()
{
	oAgentTyping.innerHTML = '&nbsp;';
}


window.onload = function()
{
	setAgentTypingOff();
	tAgent = setTimeout ( "setAgentTypingOn()", 0);
	tPost = setTimeout ( "postMessage('welcome')", TimeInit);
}