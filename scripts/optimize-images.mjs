// One-off image optimizer for existing uploaded/static photos that were
// never compressed before deploy (see chat: images taking a long time to
// render on the live host). Not part of the build — run manually with
// `npm run optimize:images` after adding new large source photos.
import sharp from 'sharp';
import { existsSync, statSync } from 'fs';

const jobs = [
    // Photos stored as PNG (lossless, wasteful for photography) -> JPEG.
    { in: 'public/images/hero/hero1.png', out: 'public/images/hero/hero1.jpg', width: 1920, quality: 90 },
    { in: 'public/images/profil/Profile-bandara 1.png', out: 'public/images/profil/Profile-bandara 1.jpg', width: 1400, quality: 90 },
    { in: 'public/images/profil/Profile-bandara 2.png', out: 'public/images/profil/Profile-bandara 2.jpg', width: 1400, quality: 90 },
    { in: 'public/images/profil/Profile-bandara 3.png', out: 'public/images/profil/Profile-bandara 3.jpg', width: 1400, quality: 90 },
    { in: 'public/images/profil/Profile-bandara 4.png', out: 'public/images/profil/Profile-bandara 4.jpg', width: 1400, quality: 90 },
    { in: 'public/images/profil/Profile-bandara 5.jpg', out: 'public/images/profil/Profile-bandara 5.jpg', width: 1400, quality: 90 },

    // Already JPEG but shot at full camera resolution for a ~672px-wide slot.
    { in: 'public/images/ppid/ppid-1.jpg', out: 'public/images/ppid/ppid-1.jpg', width: 1400, quality: 90 },
    { in: 'public/images/ppid/ppid-3.jpg', out: 'public/images/ppid/ppid-3.jpg', width: 1400, quality: 90 },

    // Logo displayed at ~28-56px tall but exported at 3375x3375.
    { in: 'public/images/ppid/logo-ppid.png', out: 'public/images/ppid/logo-ppid.png', width: 400, png: true },

    // Survey Posters
    { in: 'public/images/survei-internal.jpeg', out: 'public/images/survei-internal.jpeg', width: 1200, quality: 85 },
    { in: 'public/images/survei-kementerian-placeholder.png', out: 'public/images/survei-kementerian-placeholder.png', width: 1200, png: true },
];

// All 22 facility photos, displayed at grid-card/modal size, not full camera res.
const facilityFiles = [
    'alat-bantu-mobilitas.jpg', 'area-check-in.jpg', 'charging-station.jpg', 'food-court.jpg',
    'gedung-pkp-pk.jpg', 'jalur-landai.jpg', 'kotak-saran.jpg', 'kursi-difabel.jpg',
    'lift-difabel.jpg', 'mini-zoo.jpg', 'mobil-pemadam.jpg', 'mural-3d.jpg', 'nursery-room.jpg',
    'parkir-panel-surya.jpg', 'parkir-vip.jpg', 'passenger-handling-service.jpg', 'pusat-informasi.jpg',
    'ruang-tunggu-difabel.jpg', 'tangga-escalator.jpg', 'tenant-kafe.jpg', 'wahana-bermain.jpg', 'wrapping-bagasi.jpg',
];
for (const name of facilityFiles) {
    const path = `storage/app/public/facilities/${name}`;
    jobs.push({ in: path, out: path, width: 1000, quality: 88 });
}

let totalBefore = 0;
let totalAfter = 0;

for (const job of jobs) {
    if (!existsSync(job.in)) {
        console.log(`${job.in}: skipped (source no longer exists — already converted to ${job.out}?)`);
        continue;
    }

    const before = statSync(job.in).size;
    const pipeline = sharp(job.in).resize({ width: job.width, withoutEnlargement: true });
    const buffer = job.png
        ? await pipeline.png({ quality: 90, compressionLevel: 9 }).toBuffer()
        : await pipeline.jpeg({ quality: job.quality, mozjpeg: true }).toBuffer();

    const sharpFs = await import('fs/promises');
    const tmpPath = `${job.out}.tmp`;
    await sharpFs.writeFile(tmpPath, buffer);
    await sharpFs.rename(tmpPath, job.out);

    const after = buffer.length;
    totalBefore += before;
    totalAfter += after;
    console.log(`${job.in} -> ${job.out}: ${(before / 1024).toFixed(0)}KB -> ${(after / 1024).toFixed(0)}KB`);
}

console.log(`\nTotal: ${(totalBefore / 1024 / 1024).toFixed(1)}MB -> ${(totalAfter / 1024 / 1024).toFixed(1)}MB`);
