import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],

  build: {
    lib: {
      entry: 'src/index.ts',
      name: 'BlogPlugin',
      fileName: () => 'admin.js',
      formats: ['es'],
    },

    outDir: 'dist',

    rollupOptions: {
      external: [
        'react',
        'react-dom',
      ],
    },
  },

  define: {
    'process.env.NODE_ENV': JSON.stringify('production'),
  },
});