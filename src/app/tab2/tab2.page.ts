import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { IonicModule, ToastController } from '@ionic/angular';
import { PostProvider } from '../providers/post-providers';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-tab2',
  templateUrl: './tab2.page.html',
  styleUrls: ['./tab2.page.scss'],
  standalone: true,
  imports: [IonicModule, CommonModule, FormsModule],
})
export class Tab2Page {
  isEdit = false;

  form = {
    id: 0,
    jenis: '',
    harga: 0,
    stok: 0,
    warna: '',
    bahan: '',
    kategori: '',
    ukuran: '',
  };

  constructor(
    private router: Router,
    private toastCtrl: ToastController,
    private postPvdr: PostProvider
  ) {
    const nav = this.router.getCurrentNavigation();
    const state = nav?.extras?.state;

    if (state?.['isEdit'] && state?.['produk']) {
      this.isEdit = true;
      this.form = { ...state['produk'] };
    }
  }

  async submitForm() {
    const { jenis, harga, stok, warna, bahan, kategori, ukuran } = this.form;

    if (!jenis || !harga || !stok || !warna || !bahan || !kategori || !ukuran) {
      this.showToast('Semua field wajib diisi');
      return;
    }

    const body = {
      aksi: this.isEdit ? 'edit' : 'tambah',
      id: this.form.id,
      jenis: jenis,
      harga: harga,
      stok: stok,
      warna: warna,
      bahan: bahan,
      kategori: kategori,
      ukuran: ukuran,
    };

    this.postPvdr.postData(body, 'action.php').subscribe({
      next: (data: any) => {
        if (data && data.success) {
          this.showToast(
            this.isEdit
              ? 'Produk berhasil diubah'
              : 'Produk berhasil ditambahkan'
          );
          this.resetForm();
          this.router.navigate(['/tabs/tab1'], { state: { reload: true } });
        } else {
          this.showToast(data?.msg || 'Gagal menyimpan data');
        }
      },
      error: () => {
        this.showToast('Gagal menyambung ke server');
      },
    });
  }

  resetForm() {
    this.form = {
      id: 0,
      jenis: '',
      harga: 0,
      stok: 0,
      warna: '',
      bahan: '',
      kategori: '',
      ukuran: '',
    };
    this.isEdit = false;
  }

  async showToast(msg: string) {
    const toast = await this.toastCtrl.create({
      message: msg,
      duration: 2000,
      position: 'bottom',
    });
    toast.present();
  }
}
