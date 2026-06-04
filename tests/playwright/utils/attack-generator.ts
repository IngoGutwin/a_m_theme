import { fakerDE as faker } from "@faker-js/faker";

export const attacks = {
  xss: [
    "<script>alert(1)</script>",
    '"><img src=x onerror=alert(1)>',
    "<svg onload=alert(1)>",
    "`<script>confirm(1)</script>`",
  ],

  sql: ["' OR 1=1 --", "'; DROP TABLE users; --", '" OR "" = "', "' UNION SELECT null --"],

  htmlInjection: [
    "<b>bold</b>",
    "<iframe src='javascript:alert(1)'></iframe>",
    "<div onclick='alert(1)'>click</div>",
  ],

  overflow: ["A".repeat(1000), "B".repeat(10000), faker.string.alpha(20000)],

  unicode: ["🔥".repeat(200), "💀".repeat(500), "汉字".repeat(300), "𠜎".repeat(100)],

  malformed: ["{}", "null", "undefined", "true", "[]", "[object Object]"],

  mixedChaos: [
    `<script>${"A".repeat(5000)}</script>🔥' OR 1=1 --`,
    `"'><svg onload=alert(1)>🔥".repeat`,
  ],
};

export function randomAttack(type: keyof typeof attacks): string {
  const list = attacks[type];
  return list[Math.floor(Math.random() * list.length)];
}
