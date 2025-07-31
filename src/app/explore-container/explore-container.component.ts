import { Component, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-explore-container',
  standalone: false,
  templateUrl: './explore-container.component.html',
  styleUrls: ['./explore-container.component.scss'],
})
export class ExploreContainerComponent {
  @Input() jenis!: string;
  @Input() harga!: number;
  @Input() stok!: number;
  @Input() warna!: string;
  @Input() bahan!: string;
  @Input() kategori!: string;
  @Input() ukuran!: string;

  @Output() cardClicked = new EventEmitter<void>();

  handleClick() {
    this.cardClicked.emit();
  }

  formatRupiah(angka: number): string {
    return 'Rp ' + angka.toLocaleString('id-ID');
  }
}
