"use strict";
// we skiped use strict mode due to global access
let sound_1 = new Howl({
  src: [app_url + "/assets/media/click.mp3"],
  autoplay: false,
  loop: false,
  html5: true,
  volume: 0.5,
  muted: true,
  onend: function () {},
});
let sound_2 = new Howl({
  src: [app_url + "/assets/media/bip.mp3"],
  autoplay: false,
  loop: false,
  html5: true,
  volume: 0.5,
  muted: true,
  onend: function () {},
});
