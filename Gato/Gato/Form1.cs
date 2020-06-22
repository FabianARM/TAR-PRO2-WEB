using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Gato
{
    public partial class Form1 : Form
    {
        private ServicioGatoJose.TikTakToePortClient gato;
        private string tablero;
        public Form1()
        {
            gato = new ServicioGatoJose.TikTakToePortClient();
            tablero = "_________";
            Console.Out.WriteLine(tablero);
            InitializeComponent();
        }

        private void eventoMarcarCasilla(object sender, EventArgs e)
        {
            Label casilla = (Label)sender;

            // No marcar una que ya este marcada
            if(casilla.Text != "X" && casilla.Text != "O")
            {
                casilla.Text = "X";
                casilla.TextAlign = ContentAlignment.MiddleCenter;

                Coordenada coordenada = convertirCoordenada(int.Parse(casilla.Name));
                marcarCasilla(coordenada);
            }
        }

        private void marcarCasilla(Coordenada coordenada)
        {
            tablero = gato.turno(tablero, coordenada.x, coordenada.y, "X");
            marcarCasillaOponente();
            
        }

        private Coordenada convertirCoordenada(int posicionCasilla)
        {
            switch(posicionCasilla)
            {
                case 0: return new Coordenada(0, 0);
                case 1: return new Coordenada(0, 1);
                case 2: return new Coordenada(0, 2);
                case 3: return new Coordenada(1, 0);
                case 4: return new Coordenada(1, 1);
                case 5: return new Coordenada(1, 2);
                case 6: return new Coordenada(2, 0);
                case 7: return new Coordenada(2, 1);
                case 8: return new Coordenada(2, 2);
                default: return null;
            }
        }

        private class Coordenada
        {
            public int x { get; set; }
            public int y { get; set; }

            public Coordenada(int x, int y)
            {
                this.x = x;
                this.y = y;
            }
        }
    }

}
