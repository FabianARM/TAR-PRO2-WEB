using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Gato
{
    static class Program
    {
        /// <summary>
        /// The main entry point for the application.
        /// </summary>
        [STAThread]
        static void Main()
        {
            ServicioGatoFabian.TikTakToePortClient servidor = new ServicioGatoFabian.TikTakToePortClient();

            string resultado = servidor.turno("_________", 0, 0, "X");
            resultado = servidor.turno(resultado, 0, 1, "X");
            resultado = servidor.turno(resultado, 0, 2, "X");

            string records = servidor.obtenerRecords();


            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new Form1());
        }
    }
}
