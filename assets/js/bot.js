const botConfig = require("../../botConfig.json");
const Discord = require('discord.js');

const bot = new Discord.Client(); 

bot.on("ready", async () => {
    
    try {
        let link = await bot.generateInvite(["ADMINISTRATOR"]);
        console.log(link)
    } catch (e) {
        console.log(e.stack)
    }
});

bot.on("message", async message => {
    if(message.author.bot) return;
    if(message.channel.type === "dm") return;

    if(message.content === "Bonjour"){
        message.channel.send('Salut tout le monde');
    }

    if(message.content === "Dyno"){
        message.channel.send('Il est relou Dyno il plante H24');
    }

});

bot.login(botConfig.token);