const remoteScript = (irsModule, url, callback = null) => {
    // remoteScript(`dumper`, `https://inane.co.za/js/inane/dumperjs.js`)
    // remoteScript(`dumper`, `https://inane.co.za/js/inane/dumperjs.js`)
    // remoteScript(`underscore`, `https://inane.co.za/lib/underscore/1.12.0/underscore.js`)
    // remoteScript(`backbone`, `https://inane.co.za/lib/backbone/1.4.0/backbone.js`)

    const name = `iRemoteScript`,
        root = window,
        logger = root?.Dumper?.get(name, { level: `debug` }) || console;

    if (!root._iRemoteScript) root._iRemoteScript = [];

    // If module already loaded, we return it
    if (root._iRemoteScript.includes(irsModule)) return logger.info(irsModule, `Already loaded.`);

    // Build the file path
    const irsFile = url.concat(`?e=`).concat(Date.now());

    return new Promise(resolve => {
        import(irsFile).then((module) => {
            logger.debug(name, 'Loadded: '.concat(irsModule));

            // Also and it to the _iRemoteScript and root if a rootModule
            root._iRemoteScript.push(irsModule);

            // And finally bring it all back
            resolve(module.default);
        }).then(callback);
    });
}

Array.from(document.querySelectorAll(`.bc-size-headline3`)).map(book => {
    return {
        title: book.textContent,
        author: book.closest(`ul`).querySelector(`.authorLabel .bc-link .bc-text`).textContent,
    };
})


copy(Array.from(document.querySelectorAll(`.bc-size-headline3`)).map(book => {
    return {
        title: book.textContent,
        author: book.closest(`ul`).querySelector(`.authorLabel .bc-link .bc-text`).textContent,
    };
}))


const AudibleLibrary = [
    {
        "title": "Nefertiti's Heart",
        "author": "A. W. Exley"
    },
    {
        "title": "How to Defeat a Demon King in Ten Easy Steps",
        "author": "Andrew Rowe"
    },
    {
        "title": "Prince Lestat: The Vampire Chronicles",
        "author": "Anne Rice"
    },
    {
        "title": "Lasher",
        "author": "Anne Rice"
    },
    {
        "title": "Taltos",
        "author": "Anne Rice"
    },
    {
        "title": "Vittorio the Vampire",
        "author": "Anne Rice"
    },
    {
        "title": "The Witching Hour",
        "author": "Anne Rice"
    },
    {
        "title": "Pandora",
        "author": "Anne Rice"
    },
    {
        "title": "Blood Canticle: The Vampire Chronicles",
        "author": "Anne Rice"
    },
    {
        "title": "Blood and Gold",
        "author": "Anne Rice"
    },
    {
        "title": "Blackwood Farm: The Vampire Chronicles",
        "author": "Anne Rice"
    },
    {
        "title": "Memnoch the Devil",
        "author": "Anne Rice"
    },
    {
        "title": "Merrick",
        "author": "Anne Rice"
    },
    {
        "title": "The Tale of the Body Thief",
        "author": "Anne Rice"
    },
    {
        "title": "The Vampire Lestat",
        "author": "Anne Rice"
    },
    {
        "title": "Viva Durant and the Secret of the Silver Buttons",
        "author": "Ashli St. Armant"
    },
    {
        "title": "A Grown-Up Guide to Dinosaurs: An Audible Original",
        "author": "Ben Garrod"
    },
    {
        "title": "Inside Jobs: Tales from a Time of Quarantine",
        "author": "Ben H. Winters"
    },
    {
        "title": "Hi Bob!",
        "author": "Bob Newhart"
    },
    {
        "title": "Beezer",
        "author": "Brandon T. Snider"
    },
    {
        "title": "Life Ever After",
        "author": "Carla Grauls"
    },
    {
        "title": "The Cuckoo's Cry: An Audible Original Novella",
        "author": "Caroline Overington"
    },
    {
        "title": "The Flying Flamingo Sisters",
        "author": "Carrie Seim"
    },
    {
        "title": "The Chimes",
        "author": "Charles Dickens"
    },
    {
        "title": "A Christmas Carol: A Signature Performance by Tim Curry",
        "author": "Charles Dickens"
    },
    {
        "title": "David Copperfield",
        "author": "Charles Dickens"
    },
    {
        "title": "Stuck",
        "author": "Chris Grabenstein"
    },
    {
        "title": "Second Skin: Audible Original Novella",
        "author": "Christian White"
    },
    {
        "title": "The Predator",
        "author": "Christopher Golden"
    },
    {
        "title": "Everville: The Second Book of 'the Art'",
        "author": "Clive Barker"
    },
    {
        "title": "Weaveworld",
        "author": "Clive Barker"
    },
    {
        "title": "Great & Secret Show",
        "author": "Clive Barker"
    },
    {
        "title": "Bluebird Memories: A Journey Through Lyrics & Life",
        "author": "Common"
    },
    {
        "title": "House of Teeth",
        "author": "Dan Jolley"
    },
    {
        "title": "Dan Rather: Stories of a Lifetime",
        "author": "Dan Rather"
    },
    {
        "title": "Zero G",
        "author": "Dan Wells"
    },
    {
        "title": "Harry Clarke: With Bonus Performance: Lillian",
        "author": "David Cale"
    },
    {
        "title": "Beyond Strange Lands: An Audible Original",
        "author": "David Peterson"
    },
    {
        "title": "A Change of Plans: A Short Story",
        "author": "Dennis E. Taylor"
    },
    {
        "title": "Heaven's River: Bobiverse, Book 4",
        "author": "Dennis E. Taylor"
    },
    {
        "title": "We Are Legion (We Are Bob): Bobiverse, Book 1",
        "author": "Dennis E. Taylor"
    },
    {
        "title": "The Singularity Trap",
        "author": "Dennis E. Taylor"
    },
    {
        "title": "Girls & Boys",
        "author": "Dennis Kelly"
    },
    {
        "title": "The Roommate: The Cormac Reilly Series, Book 0.7",
        "author": "Dervla McTiernan"
    },
    {
        "title": "Unhappenings",
        "author": "Edward Aubry"
    },
    {
        "title": "Steamborn: The Complete Trilogy Box Set",
        "author": "Eric Asher"
    },
    {
        "title": "The Science of Sci-Fi: From Warp Speed to Interstellar Travel",
        "author": "Erin Macdonald"
    },
    {
        "title": "Junkyard Bargain: Shining Smith, Book 2",
        "author": "Faith Hunter"
    },
    {
        "title": "Junkyard Cats: Shining Smith, Book 1",
        "author": "Faith Hunter"
    },
    {
        "title": "The Accidental Alchemist",
        "author": "Gigi Pandian"
    },
    {
        "title": "The Getaway",
        "author": "Greer Hendricks"
    },
    {
        "title": "Godzilla: King of the Monsters: The Official Movie Novelization",
        "author": "Greg Keyes"
    },
    {
        "title": "Little Fuzzy [Audible]",
        "author": "H. Beam Piper"
    },
    {
        "title": "Bella Bella",
        "author": "Harvey Fierstein"
    },
    {
        "title": "H.P. Lovecraft, The Complete Omnibus, Volume II: 1927-1935",
        "author": "Howard Phillips Lovecraft"
    },
    {
        "title": "H.P. Lovecraft: The Complete Omnibus Collection, Volume I: 1917-1926",
        "author": "Howard Phillips Lovecraft"
    },
    {
        "title": "Malcolm and Me",
        "author": "Ishmael Reed"
    },
    {
        "title": "God of War",
        "author": "J. M. Barlog"
    },
    {
        "title": "Peter Pan: An Audible Original Drama",
        "author": "J. M. Barrie"
    },
    {
        "title": "Mercy for Hire: Mission Pack 4: Black Ocean: Mission 13-16",
        "author": "J.S. Morin"
    },
    {
        "title": "Mercy for Hire Mission Pack 3: Missions 9-12 (Black Ocean: Mercy for Hire Mission Pack)",
        "author": "J.S. Morin"
    },
    {
        "title": "Shadowblood Heir",
        "author": "J.S. Morin"
    },
    {
        "title": "Black Ocean: Astral Prime Collection: Missions 1-12",
        "author": "J.S. Morin"
    },
    {
        "title": "Void Kraken: Mission 9: Black Ocean: Astral Prime, Book 9",
        "author": "J.S. Morin"
    },
    {
        "title": "Between the Worlds: A Collection of Eight Twinborn Stories (Twinborn Chronicles, Book 8)",
        "author": "J.S. Morin"
    },
    {
        "title": "Multiversal Truth: Mission 8: Black Ocean: Astral Prime",
        "author": "J.S. Morin"
    },
    {
        "title": "Parallel Enforcers: Mission 7: Black Ocean: Astral Prime",
        "author": "J.S. Morin"
    },
    {
        "title": "Astral Messiah: Black Ocean: Astral Prime, Mission 6",
        "author": "J.S. Morin"
    },
    {
        "title": "Systemic Treachery: Mission 5 (Black Ocean: Astral Prime)",
        "author": "J.S. Morin"
    },
    {
        "title": "Astral Prime Mission Pack 1: Missions 1-4: Black Ocean: Astral Prime Mission Pack",
        "author": "J.S. Morin"
    },
    {
        "title": "Robot Geneticists: The Complete Collection, Books 1-6",
        "author": "J.S. Morin"
    },
    {
        "title": "Mercy for Hire Mission Pack 2: Black Ocean: Mercy for Hire Mission Pack, Books 5-8",
        "author": "J.S. Morin"
    },
    {
        "title": "Mercy for Hire Mission Pack 1: Missions 1-4: Black Ocean Mission Pack, Book Five",
        "author": "J.S. Morin"
    },
    {
        "title": "Twinborn Chronicles: War of 3 Worlds",
        "author": "J.S. Morin"
    },
    {
        "title": "Twinborn Chronicles: Awakening Collection",
        "author": "J.S. Morin"
    },
    {
        "title": "Galaxy Outlaws: The Complete Black Ocean Mobius Missions, 1-16.5",
        "author": "J.S. Morin"
    },
    {
        "title": "Dead Jack and the Soul Catcher",
        "author": "James Aquilone"
    },
    {
        "title": "Dead Jack and the Pandemonium Device: Dead Jack, Book 1",
        "author": "James Aquilone"
    },
    {
        "title": "Extinction Crisis",
        "author": "James D. Prescott"
    },
    {
        "title": "Extinction Countdown",
        "author": "James D. Prescott"
    },
    {
        "title": "Extinction Code",
        "author": "James D. Prescott"
    },
    {
        "title": "The Cthulhu Casebooks: Sherlock Holmes and the Shadwell Shadows: The Cthulhu Casebooks, Book 1",
        "author": "James Lovegrove"
    },
    {
        "title": "Firefly: Big Damn Hero: Firefly, Book 1",
        "author": "James Lovegrove"
    },
    {
        "title": "Letters From Camp",
        "author": "Jamie Lee Curtis"
    },
    {
        "title": "Killer by Nature: An Audible Original Drama",
        "author": "Jan Smith"
    },
    {
        "title": "Forget Nothing",
        "author": "Jason Anspach"
    },
    {
        "title": "The Land of Painted Caves: Earth's Children Series",
        "author": "Jean M. Auel"
    },
    {
        "title": "The Shelters of Stone",
        "author": "Jean M. Auel"
    },
    {
        "title": "The Plains of Passage: Earth's Children, Book 4",
        "author": "Jean M. Auel"
    },
    {
        "title": "The Mammoth Hunters: Earth’s Children, Book 3",
        "author": "Jean M. Auel"
    },
    {
        "title": "The Valley of Horses: Earth’s Children, Book 2",
        "author": "Jean M. Auel"
    },
    {
        "title": "The Clan of the Cave Bear: Earth's Children 1",
        "author": "Jean M. Auel"
    },
    {
        "title": "Sovereign",
        "author": "Jeff Hirsch"
    },
    {
        "title": "When You Finish Saving the World",
        "author": "Jesse Eisenberg"
    },
    {
        "title": "The Mystwick School of Musicraft",
        "author": "Jessica Khoury"
    },
    {
        "title": "The Year of Magical Thinking",
        "author": "Joan Didion"
    },
    {
        "title": "The X-Files: Cold Cases",
        "author": "Joe Harris"
    },
    {
        "title": "Escape from Virtual Island: An Audio Comedy",
        "author": "John Lutz"
    },
    {
        "title": "Murder by Other Means: The Dispatcher, Book 2",
        "author": "John Scalzi"
    },
    {
        "title": "The Dispatcher",
        "author": "John Scalzi"
    },
    {
        "title": "Stephen Fry’s Victorian Secrets: An Audible Original",
        "author": "John Woolf"
    },
    {
        "title": "The Vanishing Assassin",
        "author": "Jonathan Maberry"
    },
    {
        "title": "Tales from the Fire Zone",
        "author": "Jonathan Maberry"
    },
    {
        "title": "Aliens: Bug Hunt",
        "author": "Jonathan Maberry"
    },
    {
        "title": "Lullaby",
        "author": "Jonathan Maberry"
    },
    {
        "title": "Carmilla",
        "author": "Joseph Sheridan Le Fanu"
    },
    {
        "title": "Wishes and Wellingtons",
        "author": "Julie Berry"
    },
    {
        "title": "Dead and Breakfast: A Merry Ghost Inn Mystery",
        "author": "Kate Kingsbury"
    },
    {
        "title": "You Can Thank Me Later: A Novella",
        "author": "Kelly Harms"
    },
    {
        "title": "More Bedtime Stories for Cynics",
        "author": "Kirsten Kearse"
    },
    {
        "title": "A Murder of Manatees: The Further Adventures of Tom Stranger, Interdimensional Insurance Agent",
        "author": "Larry Correia"
    },
    {
        "title": "The Adventures of Tom Stranger, Interdimensional Insurance Agent",
        "author": "Larry Correia"
    },
    {
        "title": "Sherlock Holmes and the Eisendorf Enigma: Sherlock Holmes in Minnesota, Book 8",
        "author": "Larry Millett"
    },
    {
        "title": "Sherlock Holmes and the Secret Alliance",
        "author": "Larry Millett"
    },
    {
        "title": "Sherlock Holmes and the Rune Stone Mystery: The Minnesota Mysteries, Book 3",
        "author": "Larry Millett"
    },
    {
        "title": "Sherlock Holmes and the Red Demon: A Minnesota Mystery: Sherlock Holmes & Shadwell, Book 1",
        "author": "Larry Millett"
    },
    {
        "title": "Laurie Berkner's Song and Story Kitchen",
        "author": "Laurie Berkner"
    },
    {
        "title": "Interview with the Robot",
        "author": "Lee Bacon"
    },
    {
        "title": "Junk",
        "author": "Les Bohem"
    },
    {
        "title": "Oaths: Dragon Blood, Book 8",
        "author": "Lindsay Buroker"
    },
    {
        "title": "Soulblade: Dragon Blood, Book 7",
        "author": "Lindsay Buroker"
    },
    {
        "title": "Raptor: Dragon Blood, Book 6",
        "author": "Lindsay Buroker"
    },
    {
        "title": "The Blade's Memory: Dragon Blood, Book 5",
        "author": "Lindsay Buroker"
    },
    {
        "title": "Dragon Blood - Omnibus",
        "author": "Lindsay Buroker"
    },
    {
        "title": "The Messengers",
        "author": "Lindsay Joelle"
    },
    {
        "title": "Astro-Nuts",
        "author": "Logan J. Hunder"
    },
    {
        "title": "Witches Be Crazy",
        "author": "Logan J. Hunder"
    },
    {
        "title": "The Real Sherlock: An Audible Original",
        "author": "Lucinda Hawksley"
    },
    {
        "title": "The Conception of Terror: Tales Inspired by M. R. James - Volume 1: An Audible Original Drama",
        "author": "M. R. James"
    },
    {
        "title": "Sins of Angels Complete Collection: Books 1-5",
        "author": "M.A. Larkin"
    },
    {
        "title": "Nut Jobs: Cracking California's Strangest $10 Million Dollar Heist: An Audible Original",
        "author": "Marc Fennell"
    },
    {
        "title": "War of the Twins: Dragonlance: Legends, Book 2",
        "author": "Margaret Weis"
    },
    {
        "title": "Time of the Twins: Dragonlance: Legends, Book 1",
        "author": "Margaret Weis"
    },
    {
        "title": "Dragons of Spring Dawning: Dragonlance: Chronicles, Book 3",
        "author": "Margaret Weis"
    },
    {
        "title": "Dragons of Autumn Twilight: Dragonlance: Chronicles, Book 1",
        "author": "Margaret Weis"
    },
    {
        "title": "Agent 355",
        "author": "Marie Benedict"
    },
    {
        "title": "The Darkwater Bride: An Audible Original Drama",
        "author": "Marty Ross"
    },
    {
        "title": "Phreaks",
        "author": "Matthew Derby"
    },
    {
        "title": "The Weirdies",
        "author": "Michael Buckley"
    },
    {
        "title": "FREE: Professional Integrity (A Riyria Chronicles Tale)",
        "author": "Michael J. Sullivan"
    },
    {
        "title": "FREE: The Jester (A Riyria Chronicles Tale)",
        "author": "Michael J. Sullivan"
    },
    {
        "title": "Black Crow, White Snow",
        "author": "Michael Livingston"
    },
    {
        "title": "Even Tree Nymphs Get the Blues",
        "author": "Molly Harper"
    },
    {
        "title": "Silverswift",
        "author": "Natalie Lloyd"
    },
    {
        "title": "The Sandman",
        "author": "Neil Gaiman"
    },
    {
        "title": "Gatefather: The Mithermages, Book 3",
        "author": "Orson Scott Card"
    },
    {
        "title": "The Gate Thief: Mithermages, Book 2",
        "author": "Orson Scott Card"
    },
    {
        "title": "The Lost Gate: Mithermages, Book 1",
        "author": "Orson Scott Card"
    },
    {
        "title": "Heartfire: Tales of Alvin Maker, Book 5",
        "author": "Orson Scott Card"
    },
    {
        "title": "Alvin Journeyman: Tales of Alvin Maker, Book 4",
        "author": "Orson Scott Card"
    },
    {
        "title": "Prentice Alvin: Tales of Alvin Maker, Book 3",
        "author": "Orson Scott Card"
    },
    {
        "title": "Red Prophet: Tales of Alvin Maker, Book 2",
        "author": "Orson Scott Card"
    },
    {
        "title": "Seventh Son: Tales of Alvin Maker, Book 1",
        "author": "Orson Scott Card"
    },
    {
        "title": "Alvin Journeyman: The Tales of Alvin Maker, Book 4",
        "author": "Orson Scott Card"
    },
    {
        "title": "Crystal City: The Tales of Alvin Maker, Book Six",
        "author": "Orson Scott Card"
    },
    {
        "title": "Prentice Alvin: The Tales of Alvin Maker, Book 3",
        "author": "Orson Scott Card"
    },
    {
        "title": "Alita: Battle Angel - Iron City: The Official Movie Prequel",
        "author": "Pat Cadigan"
    },
    {
        "title": "Alita: Battle Angel: The Official Movie Novelization",
        "author": "Pat Cadigan"
    },
    {
        "title": "La Belle Sauvage: The Book of Dust: Volume One",
        "author": "Philip Pullman"
    },
    {
        "title": "The Secret Commonwealth: The Book of Dust, Volume Two",
        "author": "Philip Pullman"
    },
    {
        "title": "Infernal Devices: Mortal Engines, Book 3",
        "author": "Philip Reeve"
    },
    {
        "title": "A Darkling Plain: Mortal Engines, Book 4",
        "author": "Philip Reeve"
    },
    {
        "title": "Predator's Gold: Mortal Engines, Book 2",
        "author": "Philip Reeve"
    },
    {
        "title": "Mortal Engines: Mortal Engines, Book 1",
        "author": "Philip Reeve"
    },
    {
        "title": "Camp Red Moon",
        "author": "R. L. Stine"
    },
    {
        "title": "Dead Acre",
        "author": "Rhett C. Bruno"
    },
    {
        "title": "I Am Legend and Other Stories",
        "author": "Richard Matheson"
    },
    {
        "title": "The Great Switcheroo: A Roald Dahl Short Story",
        "author": "Roald Dahl"
    },
    {
        "title": "Henrietta & Eleanor: A Retelling of Jekyll and Hyde: An Audible Original Drama",
        "author": "Robert Louis Stevenson"
    },
    {
        "title": "Treasure Island: An Audible Original Drama",
        "author": "Robert Louis Stevenson"
    },
    {
        "title": "Immortality, Inc.",
        "author": "Robert Sheckley"
    },
    {
        "title": "Blood of Dragons: The Rain Wild Chronicles 4",
        "author": "Robin Hobb"
    },
    {
        "title": "City of Dragons: The Rain Wild Chronicles, Book 3",
        "author": "Robin Hobb"
    },
    {
        "title": "Dragon Haven: The Rain Wild Chronicles, Book 2",
        "author": "Robin Hobb"
    },
    {
        "title": "Dragon Keeper: The Rain Wild Chronicles, Book 1",
        "author": "Robin Hobb"
    },
    {
        "title": "Fool's Fate: The Tawny Man Trilogy, Book 3",
        "author": "Robin Hobb"
    },
    {
        "title": "The Golden Fool: The Tawny Man Trilogy, Book 2",
        "author": "Robin Hobb"
    },
    {
        "title": "Fool's Errand: Tawny Man Trilogy, Book 1",
        "author": "Robin Hobb"
    },
    {
        "title": "Assassin's Quest: The Farseer Trilogy, Book 3",
        "author": "Robin Hobb"
    },
    {
        "title": "Royal Assassin: The Farseer Trilogy, Book 2",
        "author": "Robin Hobb"
    },
    {
        "title": "Assassin’s Apprentice: The Farseer Trilogy, Book 1",
        "author": "Robin Hobb"
    },
    {
        "title": "Ship of Destiny: The Liveship Traders, Book 3",
        "author": "Robin Hobb"
    },
    {
        "title": "The Mad Ship: The Liveship Traders, Book 2",
        "author": "Robin Hobb"
    },
    {
        "title": "Ship of Magic: The Liveship Traders, Book 1",
        "author": "Robin Hobb"
    },
    {
        "title": "Once More upon a Time: A Novella",
        "author": "Roshani Chokshi"
    },
    {
        "title": "Rivals! Frenemies Who Changed the World",
        "author": "Scott McCormick"
    },
    {
        "title": "On Blueberry Hill",
        "author": "Sebastian Barry"
    },
    {
        "title": "The Free Lunch",
        "author": "Spider Robinson"
    },
    {
        "title": "Carnival Row: Tangle in the Dark",
        "author": "Stephanie K. Smith"
    },
    {
        "title": "Salem's Lot",
        "author": "Stephen King"
    },
    {
        "title": "Black House",
        "author": "Stephen King"
    },
    {
        "title": "The Talisman",
        "author": "Stephen King"
    },
    {
        "title": "Doctor Sleep: A Novel",
        "author": "Stephen King"
    },
    {
        "title": "The Wind Through the Keyhole: The Dark Tower",
        "author": "Stephen King"
    },
    {
        "title": "The Dark Tower: The Dark Tower VII",
        "author": "Stephen King"
    },
    {
        "title": "Song of Susannah: The Dark Tower VI",
        "author": "Stephen King"
    },
    {
        "title": "Wolves of the Calla: Dark Tower V",
        "author": "Stephen King"
    },
    {
        "title": "Wizard and Glass: The Dark Tower IV",
        "author": "Stephen King"
    },
    {
        "title": "The Waste Lands: The Dark Tower III",
        "author": "Stephen King"
    },
    {
        "title": "The Gunslinger: The Dark Tower I",
        "author": "Stephen King"
    },
    {
        "title": "The Drawing of the Three: The Dark Tower II",
        "author": "Stephen King"
    },
    {
        "title": "The Man on the Mountaintop: An Audible Original Drama",
        "author": "Susan Trott"
    },
    {
        "title": "The Last Druid: Fall of Shannara, Book 4",
        "author": "Terry Brooks"
    },
    {
        "title": "The Stiehl Assassin: Fall of Shannara, Book 3",
        "author": "Terry Brooks"
    },
    {
        "title": "Street Freaks",
        "author": "Terry Brooks"
    },
    {
        "title": "The Skaar Invasion: The Fall of Shannara, Book 2",
        "author": "Terry Brooks"
    },
    {
        "title": "Tanequil: High Druid of Shannara, Book 2",
        "author": "Terry Brooks"
    },
    {
        "title": "Jarka Ruus: High Druid of Shannara, Book 1",
        "author": "Terry Brooks"
    },
    {
        "title": "The Darkling Child: The Defenders of Shannara",
        "author": "Terry Brooks"
    },
    {
        "title": "The High Druid's Blade: The Defenders of Shannara",
        "author": "Terry Brooks"
    },
    {
        "title": "The Measure of the Magic: Legends of Shannara",
        "author": "Terry Brooks"
    },
    {
        "title": "Bearers of the Black Staff",
        "author": "Terry Brooks"
    },
    {
        "title": "Witch Wraith: The Dark Legacy of Shannara",
        "author": "Terry Brooks"
    },
    {
        "title": "Bloodfire Quest: The Dark Legacy of Shannara",
        "author": "Terry Brooks"
    },
    {
        "title": "Wards of Faerie: The Dark Legacy of Shannara",
        "author": "Terry Brooks"
    },
    {
        "title": "The Voyage of the Jerle Shannara: Antrax",
        "author": "Terry Brooks"
    },
    {
        "title": "The Time-Travelling Caveman",
        "author": "Terry Pratchett"
    },
    {
        "title": "A Blink of the Screen: Collected Short Fiction",
        "author": "Terry Pratchett"
    },
    {
        "title": "The Folklore of Discworld",
        "author": "Terry Pratchett"
    },
    {
        "title": "The Shepherd's Crown",
        "author": "Terry Pratchett"
    },
    {
        "title": "The Long Utopia: A Novel",
        "author": "Terry Pratchett"
    },
    {
        "title": "The New York Times Digest",
        "author": "The New York Times"
    },
    {
        "title": "The Washington Post Digest",
        "author": "The Washington Post"
    },
    {
        "title": "Alien: Out of the Shadows: An Audible Original Drama",
        "author": "Tim Lebbon"
    },
    {
        "title": "A Crazy Inheritance: Ghostsitter 1",
        "author": "Tommy Krappweis"
    },
    {
        "title": "Dodge & Twist: An Audible Original Drama",
        "author": "Tony Lee"
    },
    {
        "title": "Test of the Twins: Dragonlance: Legends, Book 3",
        "author": "Tracy Hickman"
    },
    {
        "title": "Dragons of Winter Night: Dragonlance: Chronicles, Book 2",
        "author": "Tracy Hickman"
    },
    {
        "title": "The Farthest Shore: The Earthsea Cycle, Book 3",
        "author": "Ursula K. Le Guin"
    },
    {
        "title": "The Tombs of Atuan: The Earthsea Cycle, Book 2",
        "author": "Ursula K. Le Guin"
    },
    {
        "title": "A Wizard of Earthsea: The Earthsea Cycle, Book 1",
        "author": "Ursula K. Le Guin"
    },
    {
        "title": "Alien III: An Audible Original Drama",
        "author": "William Gibson"
    }
];

const AudibleLibraryByAuthor = {
    "A. W. Exley": [
        {
            "title": "Nefertiti's Heart",
            "author": "A. W. Exley"
        }
    ],
    "Andrew Rowe": [
        {
            "title": "How to Defeat a Demon King in Ten Easy Steps",
            "author": "Andrew Rowe"
        }
    ],
    "Anne Rice": [
        {
            "title": "Prince Lestat: The Vampire Chronicles",
            "author": "Anne Rice"
        },
        {
            "title": "Lasher",
            "author": "Anne Rice"
        },
        {
            "title": "Taltos",
            "author": "Anne Rice"
        },
        {
            "title": "Vittorio the Vampire",
            "author": "Anne Rice"
        },
        {
            "title": "The Witching Hour",
            "author": "Anne Rice"
        },
        {
            "title": "Pandora",
            "author": "Anne Rice"
        },
        {
            "title": "Blood Canticle: The Vampire Chronicles",
            "author": "Anne Rice"
        },
        {
            "title": "Blood and Gold",
            "author": "Anne Rice"
        },
        {
            "title": "Blackwood Farm: The Vampire Chronicles",
            "author": "Anne Rice"
        },
        {
            "title": "Memnoch the Devil",
            "author": "Anne Rice"
        },
        {
            "title": "Merrick",
            "author": "Anne Rice"
        },
        {
            "title": "The Tale of the Body Thief",
            "author": "Anne Rice"
        },
        {
            "title": "The Vampire Lestat",
            "author": "Anne Rice"
        }
    ],
    "Ashli St. Armant": [
        {
            "title": "Viva Durant and the Secret of the Silver Buttons",
            "author": "Ashli St. Armant"
        }
    ],
    "Ben Garrod": [
        {
            "title": "A Grown-Up Guide to Dinosaurs: An Audible Original",
            "author": "Ben Garrod"
        }
    ],
    "Ben H. Winters": [
        {
            "title": "Inside Jobs: Tales from a Time of Quarantine",
            "author": "Ben H. Winters"
        }
    ],
    "Bob Newhart": [
        {
            "title": "Hi Bob!",
            "author": "Bob Newhart"
        }
    ],
    "Brandon T. Snider": [
        {
            "title": "Beezer",
            "author": "Brandon T. Snider"
        }
    ],
    "Carla Grauls": [
        {
            "title": "Life Ever After",
            "author": "Carla Grauls"
        }
    ],
    "Caroline Overington": [
        {
            "title": "The Cuckoo's Cry: An Audible Original Novella",
            "author": "Caroline Overington"
        }
    ],
    "Carrie Seim": [
        {
            "title": "The Flying Flamingo Sisters",
            "author": "Carrie Seim"
        }
    ],
    "Charles Dickens": [
        {
            "title": "The Chimes",
            "author": "Charles Dickens"
        },
        {
            "title": "A Christmas Carol: A Signature Performance by Tim Curry",
            "author": "Charles Dickens"
        },
        {
            "title": "David Copperfield",
            "author": "Charles Dickens"
        }
    ],
    "Chris Grabenstein": [
        {
            "title": "Stuck",
            "author": "Chris Grabenstein"
        }
    ],
    "Christian White": [
        {
            "title": "Second Skin: Audible Original Novella",
            "author": "Christian White"
        }
    ],
    "Christopher Golden": [
        {
            "title": "The Predator",
            "author": "Christopher Golden"
        }
    ],
    "Clive Barker": [
        {
            "title": "Everville: The Second Book of 'the Art'",
            "author": "Clive Barker"
        },
        {
            "title": "Weaveworld",
            "author": "Clive Barker"
        },
        {
            "title": "Great & Secret Show",
            "author": "Clive Barker"
        }
    ],
    "Common": [
        {
            "title": "Bluebird Memories: A Journey Through Lyrics & Life",
            "author": "Common"
        }
    ],
    "Dan Jolley": [
        {
            "title": "House of Teeth",
            "author": "Dan Jolley"
        }
    ],
    "Dan Rather": [
        {
            "title": "Dan Rather: Stories of a Lifetime",
            "author": "Dan Rather"
        }
    ],
    "Dan Wells": [
        {
            "title": "Zero G",
            "author": "Dan Wells"
        }
    ],
    "David Cale": [
        {
            "title": "Harry Clarke: With Bonus Performance: Lillian",
            "author": "David Cale"
        }
    ],
    "David Peterson": [
        {
            "title": "Beyond Strange Lands: An Audible Original",
            "author": "David Peterson"
        }
    ],
    "Dennis E. Taylor": [
        {
            "title": "A Change of Plans: A Short Story",
            "author": "Dennis E. Taylor"
        },
        {
            "title": "Heaven's River: Bobiverse, Book 4",
            "author": "Dennis E. Taylor"
        },
        {
            "title": "We Are Legion (We Are Bob): Bobiverse, Book 1",
            "author": "Dennis E. Taylor"
        },
        {
            "title": "The Singularity Trap",
            "author": "Dennis E. Taylor"
        }
    ],
    "Dennis Kelly": [
        {
            "title": "Girls & Boys",
            "author": "Dennis Kelly"
        }
    ],
    "Dervla McTiernan": [
        {
            "title": "The Roommate: The Cormac Reilly Series, Book 0.7",
            "author": "Dervla McTiernan"
        }
    ],
    "Edward Aubry": [
        {
            "title": "Unhappenings",
            "author": "Edward Aubry"
        }
    ],
    "Eric Asher": [
        {
            "title": "Steamborn: The Complete Trilogy Box Set",
            "author": "Eric Asher"
        }
    ],
    "Erin Macdonald": [
        {
            "title": "The Science of Sci-Fi: From Warp Speed to Interstellar Travel",
            "author": "Erin Macdonald"
        }
    ],
    "Faith Hunter": [
        {
            "title": "Junkyard Bargain: Shining Smith, Book 2",
            "author": "Faith Hunter"
        },
        {
            "title": "Junkyard Cats: Shining Smith, Book 1",
            "author": "Faith Hunter"
        }
    ],
    "Gigi Pandian": [
        {
            "title": "The Accidental Alchemist",
            "author": "Gigi Pandian"
        }
    ],
    "Greer Hendricks": [
        {
            "title": "The Getaway",
            "author": "Greer Hendricks"
        }
    ],
    "Greg Keyes": [
        {
            "title": "Godzilla: King of the Monsters: The Official Movie Novelization",
            "author": "Greg Keyes"
        }
    ],
    "H. Beam Piper": [
        {
            "title": "Little Fuzzy [Audible]",
            "author": "H. Beam Piper"
        }
    ],
    "Harvey Fierstein": [
        {
            "title": "Bella Bella",
            "author": "Harvey Fierstein"
        }
    ],
    "Howard Phillips Lovecraft": [
        {
            "title": "H.P. Lovecraft, The Complete Omnibus, Volume II: 1927-1935",
            "author": "Howard Phillips Lovecraft"
        },
        {
            "title": "H.P. Lovecraft: The Complete Omnibus Collection, Volume I: 1917-1926",
            "author": "Howard Phillips Lovecraft"
        }
    ],
    "Ishmael Reed": [
        {
            "title": "Malcolm and Me",
            "author": "Ishmael Reed"
        }
    ],
    "J. M. Barlog": [
        {
            "title": "God of War",
            "author": "J. M. Barlog"
        }
    ],
    "J. M. Barrie": [
        {
            "title": "Peter Pan: An Audible Original Drama",
            "author": "J. M. Barrie"
        }
    ],
    "J.S. Morin": [
        {
            "title": "Mercy for Hire: Mission Pack 4: Black Ocean: Mission 13-16",
            "author": "J.S. Morin"
        },
        {
            "title": "Mercy for Hire Mission Pack 3: Missions 9-12 (Black Ocean: Mercy for Hire Mission Pack)",
            "author": "J.S. Morin"
        },
        {
            "title": "Shadowblood Heir",
            "author": "J.S. Morin"
        },
        {
            "title": "Black Ocean: Astral Prime Collection: Missions 1-12",
            "author": "J.S. Morin"
        },
        {
            "title": "Void Kraken: Mission 9: Black Ocean: Astral Prime, Book 9",
            "author": "J.S. Morin"
        },
        {
            "title": "Between the Worlds: A Collection of Eight Twinborn Stories (Twinborn Chronicles, Book 8)",
            "author": "J.S. Morin"
        },
        {
            "title": "Multiversal Truth: Mission 8: Black Ocean: Astral Prime",
            "author": "J.S. Morin"
        },
        {
            "title": "Parallel Enforcers: Mission 7: Black Ocean: Astral Prime",
            "author": "J.S. Morin"
        },
        {
            "title": "Astral Messiah: Black Ocean: Astral Prime, Mission 6",
            "author": "J.S. Morin"
        },
        {
            "title": "Systemic Treachery: Mission 5 (Black Ocean: Astral Prime)",
            "author": "J.S. Morin"
        },
        {
            "title": "Astral Prime Mission Pack 1: Missions 1-4: Black Ocean: Astral Prime Mission Pack",
            "author": "J.S. Morin"
        },
        {
            "title": "Robot Geneticists: The Complete Collection, Books 1-6",
            "author": "J.S. Morin"
        },
        {
            "title": "Mercy for Hire Mission Pack 2: Black Ocean: Mercy for Hire Mission Pack, Books 5-8",
            "author": "J.S. Morin"
        },
        {
            "title": "Mercy for Hire Mission Pack 1: Missions 1-4: Black Ocean Mission Pack, Book Five",
            "author": "J.S. Morin"
        },
        {
            "title": "Twinborn Chronicles: War of 3 Worlds",
            "author": "J.S. Morin"
        },
        {
            "title": "Twinborn Chronicles: Awakening Collection",
            "author": "J.S. Morin"
        },
        {
            "title": "Galaxy Outlaws: The Complete Black Ocean Mobius Missions, 1-16.5",
            "author": "J.S. Morin"
        }
    ],
    "James Aquilone": [
        {
            "title": "Dead Jack and the Soul Catcher",
            "author": "James Aquilone"
        },
        {
            "title": "Dead Jack and the Pandemonium Device: Dead Jack, Book 1",
            "author": "James Aquilone"
        }
    ],
    "James D. Prescott": [
        {
            "title": "Extinction Crisis",
            "author": "James D. Prescott"
        },
        {
            "title": "Extinction Countdown",
            "author": "James D. Prescott"
        },
        {
            "title": "Extinction Code",
            "author": "James D. Prescott"
        }
    ],
    "James Lovegrove": [
        {
            "title": "The Cthulhu Casebooks: Sherlock Holmes and the Shadwell Shadows: The Cthulhu Casebooks, Book 1",
            "author": "James Lovegrove"
        },
        {
            "title": "Firefly: Big Damn Hero: Firefly, Book 1",
            "author": "James Lovegrove"
        }
    ],
    "Jamie Lee Curtis": [
        {
            "title": "Letters From Camp",
            "author": "Jamie Lee Curtis"
        }
    ],
    "Jan Smith": [
        {
            "title": "Killer by Nature: An Audible Original Drama",
            "author": "Jan Smith"
        }
    ],
    "Jason Anspach": [
        {
            "title": "Forget Nothing",
            "author": "Jason Anspach"
        }
    ],
    "Jean M. Auel": [
        {
            "title": "The Land of Painted Caves: Earth's Children Series",
            "author": "Jean M. Auel"
        },
        {
            "title": "The Shelters of Stone",
            "author": "Jean M. Auel"
        },
        {
            "title": "The Plains of Passage: Earth's Children, Book 4",
            "author": "Jean M. Auel"
        },
        {
            "title": "The Mammoth Hunters: Earth’s Children, Book 3",
            "author": "Jean M. Auel"
        },
        {
            "title": "The Valley of Horses: Earth’s Children, Book 2",
            "author": "Jean M. Auel"
        },
        {
            "title": "The Clan of the Cave Bear: Earth's Children 1",
            "author": "Jean M. Auel"
        }
    ],
    "Jeff Hirsch": [
        {
            "title": "Sovereign",
            "author": "Jeff Hirsch"
        }
    ],
    "Jesse Eisenberg": [
        {
            "title": "When You Finish Saving the World",
            "author": "Jesse Eisenberg"
        }
    ],
    "Jessica Khoury": [
        {
            "title": "The Mystwick School of Musicraft",
            "author": "Jessica Khoury"
        }
    ],
    "Joan Didion": [
        {
            "title": "The Year of Magical Thinking",
            "author": "Joan Didion"
        }
    ],
    "Joe Harris": [
        {
            "title": "The X-Files: Cold Cases",
            "author": "Joe Harris"
        }
    ],
    "John Lutz": [
        {
            "title": "Escape from Virtual Island: An Audio Comedy",
            "author": "John Lutz"
        }
    ],
    "John Scalzi": [
        {
            "title": "Murder by Other Means: The Dispatcher, Book 2",
            "author": "John Scalzi"
        },
        {
            "title": "The Dispatcher",
            "author": "John Scalzi"
        }
    ],
    "John Woolf": [
        {
            "title": "Stephen Fry’s Victorian Secrets: An Audible Original",
            "author": "John Woolf"
        }
    ],
    "Jonathan Maberry": [
        {
            "title": "The Vanishing Assassin",
            "author": "Jonathan Maberry"
        },
        {
            "title": "Tales from the Fire Zone",
            "author": "Jonathan Maberry"
        },
        {
            "title": "Aliens: Bug Hunt",
            "author": "Jonathan Maberry"
        },
        {
            "title": "Lullaby",
            "author": "Jonathan Maberry"
        }
    ],
    "Joseph Sheridan Le Fanu": [
        {
            "title": "Carmilla",
            "author": "Joseph Sheridan Le Fanu"
        }
    ],
    "Julie Berry": [
        {
            "title": "Wishes and Wellingtons",
            "author": "Julie Berry"
        }
    ],
    "Kate Kingsbury": [
        {
            "title": "Dead and Breakfast: A Merry Ghost Inn Mystery",
            "author": "Kate Kingsbury"
        }
    ],
    "Kelly Harms": [
        {
            "title": "You Can Thank Me Later: A Novella",
            "author": "Kelly Harms"
        }
    ],
    "Kirsten Kearse": [
        {
            "title": "More Bedtime Stories for Cynics",
            "author": "Kirsten Kearse"
        }
    ],
    "Larry Correia": [
        {
            "title": "A Murder of Manatees: The Further Adventures of Tom Stranger, Interdimensional Insurance Agent",
            "author": "Larry Correia"
        },
        {
            "title": "The Adventures of Tom Stranger, Interdimensional Insurance Agent",
            "author": "Larry Correia"
        }
    ],
    "Larry Millett": [
        {
            "title": "Sherlock Holmes and the Eisendorf Enigma: Sherlock Holmes in Minnesota, Book 8",
            "author": "Larry Millett"
        },
        {
            "title": "Sherlock Holmes and the Secret Alliance",
            "author": "Larry Millett"
        },
        {
            "title": "Sherlock Holmes and the Rune Stone Mystery: The Minnesota Mysteries, Book 3",
            "author": "Larry Millett"
        },
        {
            "title": "Sherlock Holmes and the Red Demon: A Minnesota Mystery: Sherlock Holmes & Shadwell, Book 1",
            "author": "Larry Millett"
        }
    ],
    "Laurie Berkner": [
        {
            "title": "Laurie Berkner's Song and Story Kitchen",
            "author": "Laurie Berkner"
        }
    ],
    "Lee Bacon": [
        {
            "title": "Interview with the Robot",
            "author": "Lee Bacon"
        }
    ],
    "Les Bohem": [
        {
            "title": "Junk",
            "author": "Les Bohem"
        }
    ],
    "Lindsay Buroker": [
        {
            "title": "Oaths: Dragon Blood, Book 8",
            "author": "Lindsay Buroker"
        },
        {
            "title": "Soulblade: Dragon Blood, Book 7",
            "author": "Lindsay Buroker"
        },
        {
            "title": "Raptor: Dragon Blood, Book 6",
            "author": "Lindsay Buroker"
        },
        {
            "title": "The Blade's Memory: Dragon Blood, Book 5",
            "author": "Lindsay Buroker"
        },
        {
            "title": "Dragon Blood - Omnibus",
            "author": "Lindsay Buroker"
        }
    ],
    "Lindsay Joelle": [
        {
            "title": "The Messengers",
            "author": "Lindsay Joelle"
        }
    ],
    "Logan J. Hunder": [
        {
            "title": "Astro-Nuts",
            "author": "Logan J. Hunder"
        },
        {
            "title": "Witches Be Crazy",
            "author": "Logan J. Hunder"
        }
    ],
    "Lucinda Hawksley": [
        {
            "title": "The Real Sherlock: An Audible Original",
            "author": "Lucinda Hawksley"
        }
    ],
    "M. R. James": [
        {
            "title": "The Conception of Terror: Tales Inspired by M. R. James - Volume 1: An Audible Original Drama",
            "author": "M. R. James"
        }
    ],
    "M.A. Larkin": [
        {
            "title": "Sins of Angels Complete Collection: Books 1-5",
            "author": "M.A. Larkin"
        }
    ],
    "Marc Fennell": [
        {
            "title": "Nut Jobs: Cracking California's Strangest $10 Million Dollar Heist: An Audible Original",
            "author": "Marc Fennell"
        }
    ],
    "Margaret Weis": [
        {
            "title": "War of the Twins: Dragonlance: Legends, Book 2",
            "author": "Margaret Weis"
        },
        {
            "title": "Time of the Twins: Dragonlance: Legends, Book 1",
            "author": "Margaret Weis"
        },
        {
            "title": "Dragons of Spring Dawning: Dragonlance: Chronicles, Book 3",
            "author": "Margaret Weis"
        },
        {
            "title": "Dragons of Autumn Twilight: Dragonlance: Chronicles, Book 1",
            "author": "Margaret Weis"
        }
    ],
    "Marie Benedict": [
        {
            "title": "Agent 355",
            "author": "Marie Benedict"
        }
    ],
    "Marty Ross": [
        {
            "title": "The Darkwater Bride: An Audible Original Drama",
            "author": "Marty Ross"
        }
    ],
    "Matthew Derby": [
        {
            "title": "Phreaks",
            "author": "Matthew Derby"
        }
    ],
    "Michael Buckley": [
        {
            "title": "The Weirdies",
            "author": "Michael Buckley"
        }
    ],
    "Michael J. Sullivan": [
        {
            "title": "FREE: Professional Integrity (A Riyria Chronicles Tale)",
            "author": "Michael J. Sullivan"
        },
        {
            "title": "FREE: The Jester (A Riyria Chronicles Tale)",
            "author": "Michael J. Sullivan"
        }
    ],
    "Michael Livingston": [
        {
            "title": "Black Crow, White Snow",
            "author": "Michael Livingston"
        }
    ],
    "Molly Harper": [
        {
            "title": "Even Tree Nymphs Get the Blues",
            "author": "Molly Harper"
        }
    ],
    "Natalie Lloyd": [
        {
            "title": "Silverswift",
            "author": "Natalie Lloyd"
        }
    ],
    "Neil Gaiman": [
        {
            "title": "The Sandman",
            "author": "Neil Gaiman"
        }
    ],
    "Orson Scott Card": [
        {
            "title": "Gatefather: The Mithermages, Book 3",
            "author": "Orson Scott Card"
        },
        {
            "title": "The Gate Thief: Mithermages, Book 2",
            "author": "Orson Scott Card"
        },
        {
            "title": "The Lost Gate: Mithermages, Book 1",
            "author": "Orson Scott Card"
        },
        {
            "title": "Heartfire: Tales of Alvin Maker, Book 5",
            "author": "Orson Scott Card"
        },
        {
            "title": "Alvin Journeyman: Tales of Alvin Maker, Book 4",
            "author": "Orson Scott Card"
        },
        {
            "title": "Prentice Alvin: Tales of Alvin Maker, Book 3",
            "author": "Orson Scott Card"
        },
        {
            "title": "Red Prophet: Tales of Alvin Maker, Book 2",
            "author": "Orson Scott Card"
        },
        {
            "title": "Seventh Son: Tales of Alvin Maker, Book 1",
            "author": "Orson Scott Card"
        },
        {
            "title": "Alvin Journeyman: The Tales of Alvin Maker, Book 4",
            "author": "Orson Scott Card"
        },
        {
            "title": "Crystal City: The Tales of Alvin Maker, Book Six",
            "author": "Orson Scott Card"
        },
        {
            "title": "Prentice Alvin: The Tales of Alvin Maker, Book 3",
            "author": "Orson Scott Card"
        }
    ],
    "Pat Cadigan": [
        {
            "title": "Alita: Battle Angel - Iron City: The Official Movie Prequel",
            "author": "Pat Cadigan"
        },
        {
            "title": "Alita: Battle Angel: The Official Movie Novelization",
            "author": "Pat Cadigan"
        }
    ],
    "Philip Pullman": [
        {
            "title": "La Belle Sauvage: The Book of Dust: Volume One",
            "author": "Philip Pullman"
        },
        {
            "title": "The Secret Commonwealth: The Book of Dust, Volume Two",
            "author": "Philip Pullman"
        }
    ],
    "Philip Reeve": [
        {
            "title": "Infernal Devices: Mortal Engines, Book 3",
            "author": "Philip Reeve"
        },
        {
            "title": "A Darkling Plain: Mortal Engines, Book 4",
            "author": "Philip Reeve"
        },
        {
            "title": "Predator's Gold: Mortal Engines, Book 2",
            "author": "Philip Reeve"
        },
        {
            "title": "Mortal Engines: Mortal Engines, Book 1",
            "author": "Philip Reeve"
        }
    ],
    "R. L. Stine": [
        {
            "title": "Camp Red Moon",
            "author": "R. L. Stine"
        }
    ],
    "Rhett C. Bruno": [
        {
            "title": "Dead Acre",
            "author": "Rhett C. Bruno"
        }
    ],
    "Richard Matheson": [
        {
            "title": "I Am Legend and Other Stories",
            "author": "Richard Matheson"
        }
    ],
    "Roald Dahl": [
        {
            "title": "The Great Switcheroo: A Roald Dahl Short Story",
            "author": "Roald Dahl"
        }
    ],
    "Robert Louis Stevenson": [
        {
            "title": "Henrietta & Eleanor: A Retelling of Jekyll and Hyde: An Audible Original Drama",
            "author": "Robert Louis Stevenson"
        },
        {
            "title": "Treasure Island: An Audible Original Drama",
            "author": "Robert Louis Stevenson"
        }
    ],
    "Robert Sheckley": [
        {
            "title": "Immortality, Inc.",
            "author": "Robert Sheckley"
        }
    ],
    "Robin Hobb": [
        {
            "title": "Blood of Dragons: The Rain Wild Chronicles 4",
            "author": "Robin Hobb"
        },
        {
            "title": "City of Dragons: The Rain Wild Chronicles, Book 3",
            "author": "Robin Hobb"
        },
        {
            "title": "Dragon Haven: The Rain Wild Chronicles, Book 2",
            "author": "Robin Hobb"
        },
        {
            "title": "Dragon Keeper: The Rain Wild Chronicles, Book 1",
            "author": "Robin Hobb"
        },
        {
            "title": "Fool's Fate: The Tawny Man Trilogy, Book 3",
            "author": "Robin Hobb"
        },
        {
            "title": "The Golden Fool: The Tawny Man Trilogy, Book 2",
            "author": "Robin Hobb"
        },
        {
            "title": "Fool's Errand: Tawny Man Trilogy, Book 1",
            "author": "Robin Hobb"
        },
        {
            "title": "Assassin's Quest: The Farseer Trilogy, Book 3",
            "author": "Robin Hobb"
        },
        {
            "title": "Royal Assassin: The Farseer Trilogy, Book 2",
            "author": "Robin Hobb"
        },
        {
            "title": "Assassin’s Apprentice: The Farseer Trilogy, Book 1",
            "author": "Robin Hobb"
        },
        {
            "title": "Ship of Destiny: The Liveship Traders, Book 3",
            "author": "Robin Hobb"
        },
        {
            "title": "The Mad Ship: The Liveship Traders, Book 2",
            "author": "Robin Hobb"
        },
        {
            "title": "Ship of Magic: The Liveship Traders, Book 1",
            "author": "Robin Hobb"
        }
    ],
    "Roshani Chokshi": [
        {
            "title": "Once More upon a Time: A Novella",
            "author": "Roshani Chokshi"
        }
    ],
    "Scott McCormick": [
        {
            "title": "Rivals! Frenemies Who Changed the World",
            "author": "Scott McCormick"
        }
    ],
    "Sebastian Barry": [
        {
            "title": "On Blueberry Hill",
            "author": "Sebastian Barry"
        }
    ],
    "Spider Robinson": [
        {
            "title": "The Free Lunch",
            "author": "Spider Robinson"
        }
    ],
    "Stephanie K. Smith": [
        {
            "title": "Carnival Row: Tangle in the Dark",
            "author": "Stephanie K. Smith"
        }
    ],
    "Stephen King": [
        {
            "title": "Salem's Lot",
            "author": "Stephen King"
        },
        {
            "title": "Black House",
            "author": "Stephen King"
        },
        {
            "title": "The Talisman",
            "author": "Stephen King"
        },
        {
            "title": "Doctor Sleep: A Novel",
            "author": "Stephen King"
        },
        {
            "title": "The Wind Through the Keyhole: The Dark Tower",
            "author": "Stephen King"
        },
        {
            "title": "The Dark Tower: The Dark Tower VII",
            "author": "Stephen King"
        },
        {
            "title": "Song of Susannah: The Dark Tower VI",
            "author": "Stephen King"
        },
        {
            "title": "Wolves of the Calla: Dark Tower V",
            "author": "Stephen King"
        },
        {
            "title": "Wizard and Glass: The Dark Tower IV",
            "author": "Stephen King"
        },
        {
            "title": "The Waste Lands: The Dark Tower III",
            "author": "Stephen King"
        },
        {
            "title": "The Gunslinger: The Dark Tower I",
            "author": "Stephen King"
        },
        {
            "title": "The Drawing of the Three: The Dark Tower II",
            "author": "Stephen King"
        }
    ],
    "Susan Trott": [
        {
            "title": "The Man on the Mountaintop: An Audible Original Drama",
            "author": "Susan Trott"
        }
    ],
    "Terry Brooks": [
        {
            "title": "The Last Druid: Fall of Shannara, Book 4",
            "author": "Terry Brooks"
        },
        {
            "title": "The Stiehl Assassin: Fall of Shannara, Book 3",
            "author": "Terry Brooks"
        },
        {
            "title": "Street Freaks",
            "author": "Terry Brooks"
        },
        {
            "title": "The Skaar Invasion: The Fall of Shannara, Book 2",
            "author": "Terry Brooks"
        },
        {
            "title": "Tanequil: High Druid of Shannara, Book 2",
            "author": "Terry Brooks"
        },
        {
            "title": "Jarka Ruus: High Druid of Shannara, Book 1",
            "author": "Terry Brooks"
        },
        {
            "title": "The Darkling Child: The Defenders of Shannara",
            "author": "Terry Brooks"
        },
        {
            "title": "The High Druid's Blade: The Defenders of Shannara",
            "author": "Terry Brooks"
        },
        {
            "title": "The Measure of the Magic: Legends of Shannara",
            "author": "Terry Brooks"
        },
        {
            "title": "Bearers of the Black Staff",
            "author": "Terry Brooks"
        },
        {
            "title": "Witch Wraith: The Dark Legacy of Shannara",
            "author": "Terry Brooks"
        },
        {
            "title": "Bloodfire Quest: The Dark Legacy of Shannara",
            "author": "Terry Brooks"
        },
        {
            "title": "Wards of Faerie: The Dark Legacy of Shannara",
            "author": "Terry Brooks"
        },
        {
            "title": "The Voyage of the Jerle Shannara: Antrax",
            "author": "Terry Brooks"
        }
    ],
    "Terry Pratchett": [
        {
            "title": "The Time-Travelling Caveman",
            "author": "Terry Pratchett"
        },
        {
            "title": "A Blink of the Screen: Collected Short Fiction",
            "author": "Terry Pratchett"
        },
        {
            "title": "The Folklore of Discworld",
            "author": "Terry Pratchett"
        },
        {
            "title": "The Shepherd's Crown",
            "author": "Terry Pratchett"
        },
        {
            "title": "The Long Utopia: A Novel",
            "author": "Terry Pratchett"
        }
    ],
    "The New York Times": [
        {
            "title": "The New York Times Digest",
            "author": "The New York Times"
        }
    ],
    "The Washington Post": [
        {
            "title": "The Washington Post Digest",
            "author": "The Washington Post"
        }
    ],
    "Tim Lebbon": [
        {
            "title": "Alien: Out of the Shadows: An Audible Original Drama",
            "author": "Tim Lebbon"
        }
    ],
    "Tommy Krappweis": [
        {
            "title": "A Crazy Inheritance: Ghostsitter 1",
            "author": "Tommy Krappweis"
        }
    ],
    "Tony Lee": [
        {
            "title": "Dodge & Twist: An Audible Original Drama",
            "author": "Tony Lee"
        }
    ],
    "Tracy Hickman": [
        {
            "title": "Test of the Twins: Dragonlance: Legends, Book 3",
            "author": "Tracy Hickman"
        },
        {
            "title": "Dragons of Winter Night: Dragonlance: Chronicles, Book 2",
            "author": "Tracy Hickman"
        }
    ],
    "Ursula K. Le Guin": [
        {
            "title": "The Farthest Shore: The Earthsea Cycle, Book 3",
            "author": "Ursula K. Le Guin"
        },
        {
            "title": "The Tombs of Atuan: The Earthsea Cycle, Book 2",
            "author": "Ursula K. Le Guin"
        },
        {
            "title": "A Wizard of Earthsea: The Earthsea Cycle, Book 1",
            "author": "Ursula K. Le Guin"
        }
    ],
    "William Gibson": [
        {
            "title": "Alien III: An Audible Original Drama",
            "author": "William Gibson"
        }
    ]
};
