function speak(text) {
    let message = new SpeechSynthesisUtterance(text);
    message.lang = "en-US";
    speechSynthesis.speak(message);
}