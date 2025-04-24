import { ZAIDNumber } from "./inane/extra/ZAIDNumber.mjs";


const idn = new ZAIDNumber();
let gen = ZAIDNumber.Gender.Male;
console.log(gen);
idn.setGender("Male");
idn.setCitizenship(ZAIDNumber.Citizenship.SouthAfricanCitizen);

console.log(idn.IDNumber, idn.birthday, idn.gender, idn.citizenship);
console.log(ZAIDNumber.Gender.Male);