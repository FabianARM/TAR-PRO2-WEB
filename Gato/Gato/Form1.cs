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
        private const string ESTADO_INICIAL = "_________";
        private const string JUGADOR = " X ";
        private const string OPONENTE = " O ";
        private const string CASILLA_VACIA = "      ";
        public Form1()
        {
            gato = new ServicioGatoJose.TikTakToePortClient();
            tablero = ESTADO_INICIAL;
            InitializeComponent();
        }

        private void eventoMarcarCasilla(object sender, EventArgs e)
        {
            Label casilla = (Label)sender;

            // No marcar una que ya este marcada
            if(casilla.Text != JUGADOR && casilla.Text != OPONENTE)
            {
                casilla.Text = JUGADOR;
                casilla.TextAlign = ContentAlignment.MiddleCenter;

                Coordenada coordenada = convertirCoordenada(int.Parse(casilla.Name[casilla.Name.Length - 1].ToString()));
                marcarCasilla(coordenada);
            }
        }

        private void marcarCasilla(Coordenada coordenada)
        {
            tablero = gato.turno(coordenada.x, coordenada.y, tablero);
            marcarCasillaOponente();
        }

        // Se marca de acuerdo a lo que tenga tablero
        private void marcarCasillaOponente()
        {
            char casilla = ' ';
            for(int contador = 0; contador < tablero.Length; ++contador)
            {
                casilla = tablero[contador];
                if(casilla == 'O')
                {
                    pintarCasillaOponente(contador);
                }
            }
        }

        private void pintarCasillaOponente(int posicion)
        {
            switch (posicion)
            {
                case 0: casilla0.Text = OPONENTE; break;
                case 1: casilla1.Text = OPONENTE; break;
                case 2: casilla2.Text = OPONENTE; break;
                case 3: casilla3.Text = OPONENTE; break;
                case 4: casilla4.Text = OPONENTE; break;
                case 5: casilla5.Text = OPONENTE; break;
                case 6: casilla6.Text = OPONENTE; break;
                case 7: casilla7.Text = OPONENTE; break;
                case 8: casilla8.Text = OPONENTE; break;
            }
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

        private void eventoReiniciar(object sender, EventArgs e)
        {
            tablero = ESTADO_INICIAL;
            casilla0.Text = CASILLA_VACIA;
            casilla1.Text = CASILLA_VACIA;
            casilla2.Text = CASILLA_VACIA;
            casilla3.Text = CASILLA_VACIA;
            casilla4.Text = CASILLA_VACIA;
            casilla5.Text = CASILLA_VACIA;
            casilla6.Text = CASILLA_VACIA;
            casilla7.Text = CASILLA_VACIA;
            casilla8.Text = CASILLA_VACIA;
        }
    }

}
