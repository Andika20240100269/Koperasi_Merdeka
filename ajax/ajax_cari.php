<?php
require '../functions.php';

$anggota = cari($_GET['keyword']);
?>

<table border="1" cellpadding="10" cellspacing="0">

    <tr>
        <th>No</th>
        <th>Foto</th>
        <th>No Anggota</th>
        <th>Nama</th>
        <th>No HP</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php if(empty($anggota)) : ?>

        <tr>
            <td colspan="7">
                <p style="color:red; font-style:italic;">
                    DATA ANGGOTA TIDAK DITEMUKAN!
                </p>
            </td>
        </tr>

    <?php endif; ?>

    <?php $no = 1; ?>

    <?php foreach($anggota as $a) : ?>

    <tr>

        <td><?= $no++; ?></td>

        <td>
            <img src="img/<?= $a['foto']; ?>"
                 width="70">
        </td>

        <td><?= $a['no_anggota']; ?></td>

        <td><?= $a['nama']; ?></td>

        <td><?= $a['no_hp']; ?></td>

        <td><?= $a['status_anggota']; ?></td>

        <td>

            <a href="detail.php?id=<?= $a['id_anggota']; ?>">
                Detail
            </a>

            |

            <a href="ubah.php?id=<?= $a['id_anggota']; ?>">
                Ubah
            </a>

            |

            <a href="hapus.php?id=<?= $a['id_anggota']; ?>"
               onclick="return confirm('Yakin hapus data?');">
                Hapus
            </a>

        </td>

    </tr>

    <?php endforeach; ?>

</table>