import { ZAIDNumber } from "./inane/extra/ZAIDNumber.mjs";


const idn = new ZAIDNumber();
let gen = ZAIDNumber.Gender.Male;
console.log(gen);
idn
    .setGender("Male")
    .setGender(ZAIDNumber.Gender.Female)
    .setCitizenship(ZAIDNumber.Citizenship.SouthAfricanCitizen)
;

console.log(idn.IDNumber, idn.birthday, idn.gender, idn.citizenship);
console.log(ZAIDNumber.Gender.Female);
console.log(ZAIDNumber.Gender.Male);
