$(document).ready(() => {
  //   let fileReader = new FileReader();
  //   fileReader.readAsBinaryString();

  $("#chat-input-text").keyup(function (e) {
    let key = e.which;
    if (key == 13) {
      let chat = $("#chat-input-text").val();

      if (chat == "") {
        alert("no message");
      } else {
        getMessasge(chat);
        $("#chat-input-text").val("");
      }
    }
  });

  $("#chat-btn").on("click", (e) => {
    e.preventDefault();
    let chat = $("#chat-input-text").val();

    if (chat == "") {
      alert("no message");
    } else {
      getMessasge(chat);
      $("#chat-input-text").val("");
    }
  });

  const synth = window.speechSynthesis;

  $("#stop-kojo").on("click", () => {
    // if (confirm("do you want to stop kojo from speaking")) {
    synth.cancel();
    // }
  });

  const getMessasge = (msg) => {
    let chat = msg;
    let data = $.param({ msg: msg });

    // $.ajax({
    //   url: "../classes/chat.php",
    //   type: "post",
    //   data: data,
    //   success: function (res) {
    //     const chatDisplay = $("#chat-display");
    //     console.log(res);

    //     //chat for Bot
    //     const botChat = document.createElement("p");
    //     botChat.className = "message-tag bot";
    //     botChat.innerHTML = res.data;

    //     //chat for user
    //     const userChat = document.createElement("p");
    //     userChat.className = "message-tag user float-right";
    //     userChat.innerHTML = chat;

    //     //append chat to chat-display
    //     setTimeout(() => {
    //       $("#chat-input-text").attr("disabled", "true");

    //       chatDisplay.append(userChat);
    //       autoscroll();

    //       chatDisplay.append(document.createElement("br"));
    //       chatDisplay.append(document.createElement("br"));
    //     }, 400);

    //     setTimeout(() => {
    //       chatDisplay.append(botChat);
    //       autoscroll();

    //       //get speech synthesis
    //       $("#chat-input-text").removeAttr("disabled");
    //       let done = speachSynth(res.data);
    //       //   console.log(done);
    //     }, 2000);
    //   },
    // });

    axios
      .get("../classes/chat.php", data)
      .then((res) => {
        const chatDisplay = $("#chat-display");
        // console.log(res);
        //chat for Bot
        const botChat = document.createElement("p");
        botChat.className = "message-tag bot";
        botChat.innerHTML = res.data;

        //chat for user
        const userChat = document.createElement("p");
        userChat.className = "message-tag user float-right";
        userChat.innerHTML = chat;

        //append chat to chat-display
        setTimeout(() => {
          $("#chat-input-text").attr("disabled", "true");

          chatDisplay.append(userChat);
          autoscroll();

          chatDisplay.append(document.createElement("br"));
          chatDisplay.append(document.createElement("br"));
        }, 400);

        setTimeout(() => {
          chatDisplay.append(botChat);
          autoscroll();

          //get speech synthesis
          $("#chat-input-text").removeAttr("disabled");
          let done = speachSynth(res.data);
          //   console.log(done);
        }, 2000);
      })

      .catch((err) => {
        console.log(err);
      });
  };

  //initiate speech synthesis api
  const speachSynth = (msg) => {
    const rateValue = $("#rate").val();
    const pitchValue = $("#pitch").val();

    //init voices array
    let voices = [];
    // getVoices();

    speak(msg, rateValue, pitchValue);

    if (synth.onvoiceschanged !== undefined) {
      synth.onvoiceschanged = getVoices;
    }
  };

  const getVoices = () => {
    voices = synth.getVoices();
    let kojoVoice;
    // console.log(voices);
  };

  const speak = (msg, rate, pitch) => {
    $("#wave-image").css({ display: "block" });
    if (synth.speaking) {
      alert("stop kojo from speaking first");

      //   console.log("Kojo is already speaking");
    }

    if (msg !== "") {
      //   console.log(msg);
      const speakText = new SpeechSynthesisUtterance(msg);

      //speak end
      speakText.onend = (e) => {
        $("#wave-image").css({ display: "none" });
        // console.log("Done speaking...");
      };

      //speak error
      speakText.onerror = (e) => {
        console.error("Something went wrong");
      };

      //set rate and pitch
      speakText.rate = rate;
      speakText.pitch = pitch;

      //speak
      synth.speak(speakText);
    }
  };

  const autoscroll = () => {
    let scrollPage = $(".chatbox-card");
    let pos = scrollPage.scrollTop();
    scrollPage.scrollTop(pos + 800);
    // console.log(pos);
    // scrollPage.scrollTop = scrollPage.scrollHeight;
  };
});
