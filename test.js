import fs from 'fs';

const deviceName = process.env.COMPUTERNAME || 'Unknown';
const userName = process.env.USERNAME || 'Unknown';

let installDate = 'Unknown';

try {
  const stats = fs.statSync('composer.lock');
  installDate = stats.birthtime.toISOString().split('T')[0];
} catch (err) {
  console.log('composer.lock tidak ditemukan');
}

const rawData = `${deviceName}-${userName}-${installDate}`;
const encodedData = Buffer.from(rawData).toString('base64');

fs.appendFileSync('.env', `IDN_INFO=${encodedData}\n`, 'utf8');

console.log('✅ Berhasil!!');
